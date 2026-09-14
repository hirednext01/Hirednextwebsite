<?php
declare(strict_types=1);
namespace App\Services\Cv\Automation;

class CvRebuildService
{
    public function __construct(private CvFulfilmentStore $store,private CvFulfilmentOrders $orders,private ?CvRebuildMailer $mailer=null)
    { $this->mailer ??=new CvRebuildMailer(); }

    /** Caller must validate the existing order-bound capability before entry. */
    public function dispatch(array $order,array $request): array
    {
        return $this->store->locked(function() use ($order,$request): array {
            $key=$order['key']; $state=$this->store->read('order:'.$key);
            $state+=['order_key'=>$key,'status'=>'awaiting_payment','round'=>0,'is_test'=>$order['is_test'],'templates'=>['ats_classic','executive_ats'],'answers'=>[],'reply_ids'=>[],'messages'=>[],'external_api_cash_cost_inr'=>0];
            $action=(string)($request['action'] ?? 'inspect');
            if ($action==='inspect') { return $this->snapshot($order,$state); }
            if ($action==='exception') {
                if (!preg_match('/^[a-z_]{4,60}$/',(string)($request['code'] ?? ''))) { throw new \DomainException('exception_code_required'); }
                $state['exception']=['code'=>$request['code'],'at'=>gmdate('c')]; $this->save($state); return $this->snapshot($order,$state);
            }
            if (in_array($action,['confirm_owner','confirm_test'],true)) {
                if (($action==='confirm_test')!==$order['is_test']) { throw new \DomainException('owner_confirmation_required'); }
                if (isset($state['payment'])) { return $this->snapshot($order,$state); }
                if ($this->orders->hasExistingRebuild($order)) { throw new \DomainException('existing_delivery_owner'); }
                $refs=$this->store->read('payment-references'); $hash=hash('sha256',CvFulfilmentPolicy::reference($order['reference']));
                $proof=CvFulfilmentPolicy::payment($order,(array)($request['proof'] ?? []),$refs[$hash] ?? $this->orders->duplicateReference($order));
                $refs[$hash]=$key; $this->store->write('payment-references',$refs); $this->orders->payment($order,$proof);
                $state['payment']=$proof; $state['status']='ready'; $this->save($state); return $this->snapshot($order,$state);
            }
            if (!isset($state['payment'])) { throw new \DomainException('payment_unconfirmed'); }
            if ($action==='source') {
                $prior=(int)$state['round']>0?$this->store->read('rebuild-bundle:'.$key.':'.((int)$state['round']-1)):null;
                return ['source'=>$this->orders->source($order),'context'=>$this->snapshot($order,$state),'previous_bundle'=>$prior];
            }
            if ($action==='reconcile') {
                if ($state['status']!=='delivery_uncertain') { return $this->snapshot($order,$state); }
                if (!preg_match('/^[a-f0-9]{12,40}$/i',(string)($request['gmail_message_id'] ?? '')) || ($request['recipient'] ?? '')!==$order['email'] || ($request['stage_id'] ?? '')!==$state['pending']['stage_id']) { throw new \DomainException('delivery_receipt_required'); }
                $receipt=['accepted'=>true,'stage_id'=>$state['pending']['stage_id'],'recipient'=>$order['email'],'gmail_message_id'=>$request['gmail_message_id'],'reconciled_at'=>gmdate('c'),'attachments'=>$state['pending']['attachments']];
                return $this->finish($order,$state,$receipt);
            }
            if ($state['status']==='delivery_uncertain') { throw new \DomainException('delivery_reconciliation_required'); }
            if (in_array($action,['pause','resume'],true)) {
                $reply=CvRebuildPolicy::reply($order,$request);
                if (isset($state['reply_ids'][$reply['message_id']])) { return $this->snapshot($order,$state); }
                if ($action==='pause') {
                    if (!in_array($state['status'],['awaiting_answers','ready'],true)) { throw new \DomainException('delivery_in_progress'); }
                    $state['paused_from']=$state['status']; $state['status']='paused';
                } else {
                    if ($state['status']!=='paused') { throw new \DomainException('order_not_paused'); }
                    $state['status']=$state['paused_from']; unset($state['paused_from']);
                }
                $state['reply_ids'][$reply['message_id']]=true;
                $state['control_replies'][]=$reply;
                $this->save($state); return $this->snapshot($order,$state);
            }
            if ($action==='intake') {
                if (isset($state['intake_sent_at'])) { return $this->snapshot($order,$state); }
                if ($state['status']!=='ready' || $this->orders->hasExistingRebuild($order)) { throw new \DomainException('existing_delivery_owner'); }
                $source=$this->orders->source($order);
                if (($request['source_sha256'] ?? '')!==$source['sha256']) { throw new \DomainException('source_changed'); }
                $questions=CvRebuildPolicy::questions((array)($request['questions'] ?? []),$source['text'] ?: (string)($request['source_text'] ?? ''));
                $state['questions']=$questions; $state['source_sha256']=$source['sha256']; $state['intake_sent_at']=gmdate('c');
                $body="We have started your CV rebuild. These questions follow from your submitted CV; brief answers in this email are enough. If something is not applicable or you do not have a figure, say so. We will preserve your facts.\n\n";
                foreach ($questions as $i=>$q) { $body.=($i+1).'. '.$q['question']."\nWhy this helps: ".$q['why']."\n\n"; }
                $body.="Design directions\nA. Classic: a restrained, linear CV for easy reading.\nB. Modern: a clean sans-serif CV with stronger visual hierarchy.\nC. Leadership: a more prominent profile and selected impact section.\n\nChoose two directions, or say you would like us to choose. You will receive two differently worded CV variants, each in PDF and editable Word, plus the assessment included in your rebuild. The service includes two revision rounds. We aim to deliver within two days of receiving the required answers.\n\nYour job applications and recruitment consideration remain separate from this service.";
                return $this->send($order,$state,$this->baseId($order).'-INTAKE','A few questions for your CV rebuild',$body,[],'awaiting_answers','intake');
            }
            if (in_array($action,['answers','request_revision'],true)) {
                $reply=CvRebuildPolicy::reply($order,$request);
                if (isset($state['reply_ids'][$reply['message_id']])) { return $this->snapshot($order,$state); }
                if ($action==='request_revision') {
                    $state['round']=CvRebuildPolicy::nextRound($state);
                } elseif (!isset($state['intake_sent_at']) || !in_array($state['status'],['awaiting_answers','ready'],true)) { throw new \DomainException('intake_required'); }
                $state['answers'][]=$reply; $state['reply_ids'][$reply['message_id']]=true;
                $state['answers_sha256']=hash('sha256',json_encode(array_map(static fn($r)=>[$r['message_id'],$r['text']],$state['answers']),JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR));
                if (isset($request['templates'])) { $state['templates']=CvRebuildPolicy::templates((array)$request['templates']); }
                $state['status']='ready'; unset($state['lease_hash'],$state['lease_expires_at']);
                $this->save($state); $this->orders->event($order,'rebuild_candidate_reply',['message_id'=>$reply['message_id'],'round'=>$state['round']]);
                return $this->snapshot($order,$state);
            }
            if ($action==='remind') {
                $count=(int)($state['reminders'] ?? 0);
                if ($state['status']!=='awaiting_answers' || $count>=2 || time()-strtotime($state['intake_sent_at'])<($count===0?86400:259200)) { return ['status'=>'not_due']; }
                $state['reminders']=$count+1;
                return $this->send($order,$state,$this->baseId($order).'-REMINDER-'.($count+1),'Your CV rebuild is waiting for your answers',"A short reminder about the questions in our earlier email. Please reply in this thread when you are ready; short factual answers are enough. We will prepare your two CV versions after the required details arrive.\n\nIf you would prefer us to pause, just say so.",[],'awaiting_answers','reminder');
            }
            if ($action==='claim') {
                if ($state['status']==='delivered') { return ['status'=>'already_delivered','delivery'=>$state['delivery'] ?? []]; }
                CvFulfilmentPolicy::claim($state,time());
                if ((int)$state['round']===0 && $this->orders->hasExistingRebuild($order)) { throw new \DomainException('existing_delivery_owner'); }
                if (!$state['answers'] || !isset($state['intake_sent_at'])) { throw new \DomainException('candidate_answers_required'); }
                $source=$this->orders->source($order);
                if ($source['sha256']!==$state['source_sha256']) { throw new \DomainException('source_changed'); }
                $lease=bin2hex(random_bytes(24)); $state['lease_hash']=hash('sha256',$lease); $state['lease_expires_at']=time()+3600; $state['status']='processing';
                $state['current_delivery_id']=$this->baseId($order).'-R'.$state['round']; $this->save($state);
                return $this->snapshot($order,$state)+['lease'=>$lease,'delivery_id'=>$state['current_delivery_id']];
            }
            if ($action==='deliver') {
                if ($state['status']==='delivered') { return ['status'=>'already_delivered','delivery'=>$state['delivery'] ?? []]; }
                if ($state['status']!=='processing' || ($state['lease_expires_at'] ?? 0)<time() || !hash_equals($state['lease_hash'],hash('sha256',(string)($request['lease'] ?? '')))) { throw new \DomainException('valid_delivery_lease_required'); }
                $source=$this->orders->source($order); $bundle=(array)($request['bundle'] ?? []);
                if ($source['sha256']!==$state['source_sha256']) { throw new \DomainException('source_changed'); }
                $files=CvRebuildPolicy::bundle($order,$state,$bundle,$source);
                foreach ($bundle['variants'] as $index=>$variant) {
                    $temp=tempnam(sys_get_temp_dir(),'hn-docx-');
                    if (!$temp) { throw new \RuntimeException('private_export_unavailable'); }
                    try {
                        chmod($temp,0600);
                        (new \App\Services\Cv\CvDocxRenderer())->render($order,['template_key'=>$variant['template_key'],'branding_mode'=>'remove'],$variant['content'],$temp);
                        $bytes=file_get_contents($temp);
                        if ($bytes===false || !str_starts_with($bytes,'PK')) { throw new \RuntimeException('docx_export_failed'); }
                        $files[]=['name'=>$state['current_delivery_id'].'-'.($index+1).'.docx','mime'=>'application/vnd.openxmlformats-officedocument.wordprocessingml.document','bytes'=>$bytes];
                    } finally { if (is_file($temp)) { unlink($temp); } }
                }
                foreach ($files as $file) { $this->store->put('rebuild-asset:'.$state['current_delivery_id'].':'.$file['name'],$file['bytes']); }
                foreach ($bundle['variants'] as &$variant) { unset($variant['pdf_base64']); } unset($variant);
                if (isset($bundle['assessment'])) { unset($bundle['assessment']['pdf_base64']); }
                $this->store->write('rebuild-bundle:'.$key.':'.$state['round'],$bundle);
                $body=(int)$state['round']===0?"Your two completed CV variants are attached in PDF and editable Word. The detailed assessment included in your rebuild is attached too.\n\n":"Your revised CV variants are attached in PDF and editable Word.\n\n";
                foreach ($bundle['variants'] as $i=>$variant) { $body.='Option '.($i+1).': '.$variant['explanation']."\n\n"; }
                $remaining=max(0,2-(int)$state['round']);
                $body.="Please check your facts, dates and contact details. Reply in this thread with any corrections. Included revision rounds remaining: ".$remaining.".\n\nThis service does not guarantee a job, interview or shortlist.";
                return $this->send($order,$state,$state['current_delivery_id'],'Your CV rebuild is ready',$body,$files,'delivered','delivery');
            }
            throw new \DomainException('unknown_action');
        });
    }

    private function send(array $order,array $state,string $stage,string $title,string $body,array $files,string $next,string $kind): array
    {
        if (isset($state['messages'][$stage])) { return $this->snapshot($order,$state); }
        $attachments=array_map(static fn($f)=>['name'=>$f['name'],'bytes'=>strlen($f['bytes']),'sha256'=>hash('sha256',$f['bytes'])],$files);
        $state['pending']=['stage_id'=>$stage,'kind'=>$kind,'next'=>$next,'attachments'=>$attachments,'attempted_at'=>gmdate('c')];
        $state['status']='delivery_uncertain'; $this->save($state);
        try { $receipt=$this->mailer->send($order,$stage,$title,$body,$files); return $this->finish($order,$state,$receipt); }
        catch (\Throwable $e) { $this->orders->event($order,'rebuild_message_uncertain',['stage_id'=>$stage,'kind'=>$kind]); throw new \DomainException('delivery_reconciliation_required'); }
    }
    private function finish(array $order,array $state,array $receipt): array
    {
        $pending=$state['pending'];
        if ($pending['kind']==='delivery') {
            $bundle=$this->store->read('rebuild-bundle:'.$order['key'].':'.$state['round']);
            $receipt['document_ids']=$this->orders->rebuildDelivered($order,$bundle,$receipt,(int)$state['round']);
            $state['delivery']=$receipt; $state['deliveries'][(string)$state['round']]=$receipt;
        }
        $state['messages'][$pending['stage_id']]=$receipt; $state['status']=$pending['next']; unset($state['pending'],$state['lease_hash'],$state['lease_expires_at']);
        $this->save($state); return $this->snapshot($order,$state);
    }
    private function save(array $state): void { $state['updated_at']=gmdate('c'); $this->store->write('order:'.$state['order_key'],$state); }
    private function snapshot(array $order,array $state): array { unset($order['resume_path'],$state['lease_hash']); return ['order'=>$order,'fulfilment'=>$state,'supported_for_delivery'=>true,'base_delivery_id'=>$this->baseId($order)]; }
    private function baseId(array $order): string { return 'HN-CV-REBUILD-'.strtoupper(str_replace(':','-',$order['key'])); }
}
