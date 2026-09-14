<?php
declare(strict_types=1);
namespace App\Services\Cv\Automation;

use App\Models\CvReportVersionModel;
use App\Services\Cv\CvAuditService;
use App\Services\Cv\CvTextExtractor;

class CvFulfilmentOrders
{
    public function load(string $key): array
    {
        if (!preg_match('/^(assessment|upgrade):([1-9][0-9]{0,9})$/',$key,$parts)) { throw new \DomainException('access_denied'); }
        $db=db_connect(); $upgrade=null;
        if ($parts[1]==='upgrade') {
            $upgrade=$db->table('cv_upgrade_orders')->where('id',(int)$parts[2])->get()->getRowArray();
            if (!$upgrade) { throw new \DomainException('access_denied'); }
        }
        $leadId=$upgrade ? (int)$upgrade['lead_id'] : (int)$parts[2];
        $lead=$db->table('cv_assessment_leads')->where('id',$leadId)->get()->getRowArray();
        if (!$lead) { throw new \DomainException('access_denied'); }
        $fixtureService=['automation_test_599'=>'priority_599','automation_test_1799'=>'rebuild_1799'][$lead['assessment_plan'] ?? ''] ?? null;
        $isTest=$fixtureService!==null && strtolower($lead['email'] ?? '')==='jobs@hirednext.info' && (int)$lead['amount']===0 && (!$upgrade || ((int)$upgrade['amount']===0 && $upgrade['tier']===$fixtureService));
        return ['key'=>$key,'lead_id'=>$leadId,'upgrade_id'=>$upgrade ? (int)$upgrade['id'] : null,
            'service'=>$isTest ? $fixtureService : ($upgrade['tier'] ?? $lead['assessment_plan']),
            'name'=>(string)$lead['name'],'email'=>strtolower(trim((string)$lead['email'])),'phone'=>(string)($lead['phone'] ?? ''),
            'amount'=>(int)($upgrade['amount'] ?? $lead['amount']),
            'reference'=>(string)($upgrade['payment_reference'] ?? $lead['payment_id'] ?? ''),
            'payment_status'=>(string)($upgrade['status'] ?? $lead['payment_status']),
            'order_status'=>(string)($upgrade['status'] ?? $lead['status']),
            'target_role'=>(string)($lead['job_title'] ?? ''),'message'=>(string)($lead['message'] ?? ''),
            'resume_path'=>(string)($lead['resume_path'] ?? ''),'is_test'=>$isTest];
    }

    public function source(array $order): array
    {
        $root=realpath(ROOTPATH); $path=realpath(ROOTPATH.ltrim($order['resume_path'],'/'));
        if (!$root || !$path || !str_starts_with($path,$root.DIRECTORY_SEPARATOR) || !is_file($path) || !is_readable($path) || filesize($path)>5*1024*1024) { throw new \DomainException('source_unavailable'); }
        $text='';
        try { $text=(new CvTextExtractor())->extract($path,false)['text']; } catch (\Throwable $e) { /* The connected worker can extract the original file locally. Never call an API fallback here. */ }
        return ['sha256'=>hash_file('sha256',$path),'filename'=>basename($path),'text'=>$text,'base64'=>base64_encode((string)file_get_contents($path))];
    }

    public function duplicateReference(array $order): ?string
    {
        $db=db_connect(); $ref=CvFulfilmentPolicy::reference($order['reference']);
        $leadRows=$db->table('cv_assessment_leads')->select('id,payment_id')->where('payment_id',$order['reference'])->get()->getResultArray();
        foreach ($leadRows as $row) {
            if ((int)$row['id']!==(int)$order['lead_id'] && CvFulfilmentPolicy::reference((string)$row['payment_id'])===$ref) { return 'assessment:'.$row['id']; }
        }
        if ($db->tableExists('cv_upgrade_orders')) {
            $rows=$db->table('cv_upgrade_orders')->select('id,lead_id,payment_reference,tier')->where('payment_reference',$order['reference'])->get()->getResultArray();
            foreach ($rows as $row) {
                if ((int)$row['id']!==(int)($order['upgrade_id'] ?? 0) && CvFulfilmentPolicy::reference((string)$row['payment_reference'])===$ref) { return 'upgrade:'.$row['id']; }
            }
        }
        return null;
    }

    public function hasExistingWork(array $order): bool
    {
        $db=db_connect();
        if (in_array($order['order_status'],['completed','closed','in_fulfilment'],true)) { return true; }
        return $db->tableExists('cv_report_versions') && $db->table('cv_report_versions')->where('lead_id',$order['lead_id'])->countAllResults()>0;
    }

    public function payment(array $order,array $proof): void
    {
        $status=$order['is_test'] ? 'internal_test' : 'owner_confirmed';
        $db=db_connect(); $now=date('Y-m-d H:i:s');
        if ($order['upgrade_id']) {
            if (!$db->table('cv_upgrade_orders')->where('id',$order['upgrade_id'])->update(['status'=>$status,'verified_at'=>$now,'updated_at'=>$now])) { throw new \RuntimeException('payment_record_failed'); }
        } else {
            if (!$db->table('cv_assessment_leads')->where('id',$order['lead_id'])->update(['payment_status'=>$status,'status'=>$order['is_test']?'internal_test':'in_review','updated_at'=>$now])) { throw new \RuntimeException('payment_record_failed'); }
        }
        $this->event($order,'automation_payment_confirmed',['order_key'=>$order['key'],'proof'=>$proof]);
    }

    public function hasExistingRebuild(array $order): bool
    {
        $db=db_connect();
        if (!$db->tableExists('cv_documents')) { throw new \RuntimeException('cv_studio_unavailable'); }
        if (in_array($order['order_status'],['completed','closed','in_fulfilment','delivered'],true)) { return true; }
        $query=$db->table('cv_documents')->where('lead_id',$order['lead_id']);
        $query->where('upgrade_order_id',$order['upgrade_id'] ?: null);
        return $query->countAllResults()>0;
    }

    public function rebuildDelivered(array $order,array $bundle,array $receipt,int $round): array
    {
        $db=db_connect(); $now=date('Y-m-d H:i:s'); $ids=[];
        $provenance=json_encode(['delivery_id'=>$bundle['delivery_id'],'source_sha256'=>$bundle['source_sha256'],'answers_sha256'=>$bundle['answers_sha256'],'external_api_cost_inr'=>0],JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR);
        foreach ($bundle['variants'] as $variant) {
            $model=new \App\Models\CvDocumentModel();
            $existing=$model->where('lead_id',$order['lead_id'])->where('upgrade_order_id',$order['upgrade_id'] ?: null)->where('template_key',$variant['template_key'])->where('revision_round',$round)->where('writer_panel_json',$provenance)->first();
            $id=$existing['id'] ?? $model->insert(['lead_id'=>$order['lead_id'],'upgrade_order_id'=>$order['upgrade_id'] ?: null,'analysis_run_id'=>null,'template_key'=>$variant['template_key'],'status'=>'delivered','content_json'=>json_encode($variant['content'],JSON_UNESCAPED_UNICODE|JSON_THROW_ON_ERROR),'writer_panel_json'=>$provenance,'clarifications_json'=>'[]','branding_mode'=>'remove','revision_round'=>$round,'created_by'=>null,'created_at'=>$now,'updated_at'=>$now,'delivered_at'=>$now],true);
            if (!$id) { throw new \RuntimeException('cv_document_record_failed'); }
            $ids[]=(int)$id;
        }
        if ($round===0) { $this->delivered($order,$bundle['assessment']['report'],$receipt); }
        $table=$order['upgrade_id']?'cv_upgrade_orders':'cv_assessment_leads';
        if (!$db->table($table)->where('id',$order['upgrade_id'] ?: $order['lead_id'])->update(['status'=>$order['is_test']?'internal_test':'completed','updated_at'=>$now])) { throw new \RuntimeException('rebuild_order_record_failed'); }
        $this->event($order,'automatic_rebuild_delivered',['order_key'=>$order['key'],'round'=>$round,'document_ids'=>$ids,'receipt'=>$receipt,'is_test'=>$order['is_test']]);
        return $ids;
    }

    public function delivered(array $order,array $report,array $receipt): void
    {
        $db=db_connect(); $now=date('Y-m-d H:i:s');
        // Preserve the full structured assessment in the existing report record.
        $id=$report['delivery_id'];
        $text=''; foreach ($report['pages'] as $page) { $text.=$page['title']."\n\n"; foreach ($page['sections'] as $section) { $text.=$section['heading']."\n".$section['text']."\n\n"; } }
        $legacy=$report+['report_title'=>'HiredNext CV Assessment Report','candidate_email'=>$order['email'],'job_title'=>$order['target_role'],'report_id'=>$id,'report_date'=>date('d M Y'),'recruiter_summary'=>$report['pages'][0]['sections'][0]['text'],'overall_verdict'=>$report['pages'][2]['sections'][0]['text'],'scores'=>[], 'strengths'=>[], 'priority_changes'=>[], 'recommended_next_step'=>[], 'methodology'=>'Prepared from the submitted CV with automated evidence and layout checks.','disclaimer'=>'This assessment does not guarantee an interview, shortlist or placement.'];
        $model=new CvReportVersionModel();
        $existing=$model->where('lead_id',$order['lead_id'])->where('report_text',$text)->first();
        if (!$existing) {
            $latest=$model->where('lead_id',$order['lead_id'])->orderBy('version','DESC')->first();
            if (!$model->insert(['lead_id'=>$order['lead_id'],'analysis_run_id'=>null,'version'=>(int)($latest['version'] ?? 0)+1,'status'=>'sent','report_json'=>json_encode($legacy,JSON_UNESCAPED_UNICODE|JSON_THROW_ON_ERROR),'report_text'=>$text,'human_notes'=>null,'approved_by'=>null,'approved_at'=>null,'sent_at'=>$now,'created_at'=>$now,'updated_at'=>$now],true)) { throw new \RuntimeException('report_record_failed'); }
        }
        $table=$order['upgrade_id']?'cv_upgrade_orders':'cv_assessment_leads'; $recordId=$order['upgrade_id'] ?: $order['lead_id'];
        if (!$db->table($table)->where('id',$recordId)->update(['status'=>$order['is_test']?'internal_test':'completed','updated_at'=>$now])) { throw new \RuntimeException('delivery_record_failed'); }
        $this->event($order,'automatic_report_delivered',['order_key'=>$order['key'],'receipt'=>$receipt,'is_test'=>$order['is_test']]);
    }

    public function event(array $order,string $event,array $data): void
    {
        (new CvAuditService())->record($order['lead_id'],$event,$data,null,'automation',$event);
    }
}
