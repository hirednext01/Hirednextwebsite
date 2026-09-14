<?php
declare(strict_types=1);
namespace App\Services\Cv\Automation;

final class CvRebuildPolicy
{
    public static function templates(array $values): array
    {
        if (count($values)!==2 || count(array_unique($values))!==2 || array_diff($values,['ats_classic','ats_modern','executive_ats'])) { throw new \DomainException('two_distinct_templates_required'); }
        return array_values($values);
    }
    public static function reply(array $order,array $request): array
    {
        $id=(string)($request['gmail_message_id'] ?? ''); $text=trim((string)($request['text'] ?? ''));
        if (strtolower(trim((string)($request['sender_email'] ?? '')))!==$order['email'] || !preg_match('/^[a-f0-9]{12,40}$/i',$id) || strlen($text)<2 || strlen($text)>30000) { throw new \DomainException('candidate_reply_required'); }
        return ['message_id'=>$id,'sender'=>$order['email'],'text'=>$text,'recorded_at'=>gmdate('c')];
    }
    public static function nextRound(array $state): int
    {
        if (($state['status'] ?? '')!=='delivered') { throw new \DomainException('delivery_in_progress'); }
        if ((int)($state['round'] ?? 0)>=2) { throw new \DomainException('included_revisions_exhausted'); }
        return (int)($state['round'] ?? 0)+1;
    }
    public static function questions(array $questions,string $source): array
    {
        if (count($questions)<1 || count($questions)>10) { throw new \DomainException('focused_questions_required'); }
        $normal=self::normal($source);
        foreach ($questions as $q) {
            if (strlen(trim((string)($q['question'] ?? '')))<15 || strlen((string)$q['question'])>600 || strlen(trim((string)($q['why'] ?? '')))<15) { throw new \DomainException('focused_questions_required'); }
            $quote=self::normal((string)($q['source_quote'] ?? ''));
            if (strlen($quote)<12 || !str_contains($normal,$quote)) { throw new \DomainException('unsupported_evidence'); }
        }
        return $questions;
    }
    /** Validate content and return decoded PDF assets. DOCX is rendered by the website. */
    public static function bundle(array $order,array $state,array $bundle,array $source): array
    {
        foreach (['source_sha256'=>$source['sha256'],'answers_sha256'=>$state['answers_sha256'],'delivery_id'=>$state['current_delivery_id'],'candidate_name'=>$order['name'],'candidate_email'=>$order['email'],'candidate_phone'=>$order['phone'] ?? ''] as $key=>$expected) {
            if (($bundle[$key] ?? '')!==$expected) { throw new \DomainException('rebuild_context_changed'); }
        }
        if (($bundle['external_api_cost_inr'] ?? null)!==0) { throw new \DomainException('new_api_spend_forbidden'); }
        foreach (['facts_checked','no_invented_claims','layout_checked'] as $flag) { if (($bundle['quality'][$flag] ?? false)!==true) { throw new \DomainException('quality_check_required'); } }
        $sourceText=trim($source['text'] ?: (string)($bundle['source_text'] ?? ''));
        if (strlen($sourceText)<120) { throw new \DomainException('readable_source_required'); }
        $evidenceText=$sourceText."\n".implode("\n",array_column($state['answers'] ?? [],'text'));
        $normal=self::normal($evidenceText);
        $variants=$bundle['variants'] ?? [];
        if (!is_array($variants) || count($variants)!==2) { throw new \DomainException('two_distinct_templates_required'); }
        $templates=self::templates(array_column($variants,'template_key'));
        $wanted=$state['templates']; sort($wanted); $actual=$templates; sort($actual);
        if ($wanted!==$actual) { throw new \DomainException('selected_templates_required'); }
        $files=[]; $contentHashes=[];
        foreach ($variants as $index=>$v) {
            $content=$v['content'] ?? []; $roles=$content['experience'] ?? [];
            if (!is_array($content) || strlen((string)($content['summary'] ?? ''))<50 || !is_array($roles) || !$roles || !empty($content['clarifications']) || strlen((string)($v['explanation'] ?? ''))<30) { throw new \DomainException('complete_cv_required'); }
            foreach ($roles as $role) {
                foreach (['company','title'] as $field) {
                    $value=self::normal((string)($role[$field] ?? ''));
                    if (strlen($value)<2 || !str_contains($normal,$value)) { throw new \DomainException('unsupported_career_fact'); }
                }
                if (strlen(trim((string)($role['dates'] ?? '')))<4 || !is_array($role['bullets'] ?? null) || !$role['bullets']) { throw new \DomainException('complete_cv_required'); }
            }
            $quotes=$v['source_quotes'] ?? [];
            if (!is_array($quotes) || !$quotes) { throw new \DomainException('evidence_required'); }
            foreach ($quotes as $quote) { $q=self::normal((string)$quote); if (strlen($q)<12 || !str_contains($normal,$q)) { throw new \DomainException('unsupported_evidence'); } }
            $narrative=json_encode($content,JSON_UNESCAPED_UNICODE|JSON_THROW_ON_ERROR);
            if (strlen($narrative)>50000 || preg_match('/guaranteed (?:job|interview|shortlist)|reviewed personally by Taru/i',$narrative)) { throw new \DomainException('unsupported_promise'); }
            // Preserve exact stated figures; do not smuggle invented metrics into a polished rewrite.
            preg_match_all('/\d[\d,]*(?:\.\d+)?/u',$narrative,$numbers);
            $numericSource=str_replace(',','',$evidenceText);
            foreach (array_unique($numbers[0]) as $number) { if (!preg_match('/(?<![0-9])'.preg_quote(str_replace(',','',$number),'/').'(?![0-9])/u',$numericSource)) { throw new \DomainException('unsupported_numeric_claim'); } }
            $pdf=base64_decode((string)($v['pdf_base64'] ?? ''),true);
            if ($pdf===false || strlen($pdf)>1000000 || !str_starts_with($pdf,'%PDF-') || !str_contains($pdf,'%%EOF') || !in_array(preg_match_all('~/Type\s*/Page\b~',$pdf),[1,2,3,4],true) || preg_match('~/(?:JavaScript|JS|Launch|EmbeddedFile)\b~',$pdf)) { throw new \DomainException('valid_cv_pdf_required'); }
            $manifest=[$order['name'],$order['email'],$order['phone'] ?? '',$v['template_key'],$bundle['delivery_id'],$source['sha256'],$state['answers_sha256'],$content];
            $digest=hash('sha256',json_encode($manifest,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR));
            if (!str_contains($pdf,'HN_CV_SHA256:'.$digest)) { throw new \DomainException('pdf_content_mismatch'); }
            $files[]=['name'=>$bundle['delivery_id'].'-'.($index+1).'.pdf','mime'=>'application/pdf','bytes'=>$pdf];
            $contentHashes[]=hash('sha256',$narrative);
        }
        if ($contentHashes[0]===$contentHashes[1]) { throw new \DomainException('distinct_cv_wording_required'); }
        if ((int)$state['round']===0) {
            $assessment=$bundle['assessment'] ?? []; $report=$assessment['report'] ?? [];
            $pdf=base64_decode((string)($assessment['pdf_base64'] ?? ''),true);
            if (($report['candidate_name'] ?? '')!==$order['name'] || ($report['delivery_id'] ?? '')!==$bundle['delivery_id'].'-ASSESSMENT' || $pdf===false) { throw new \DomainException('included_assessment_required'); }
            CvFulfilmentPolicy::report($report,$source['sha256'],$evidenceText,$pdf);
            $files[]=['name'=>$report['delivery_id'].'.pdf','mime'=>'application/pdf','bytes'=>$pdf];
        }
        return $files;
    }
    private static function normal(string $value): string { return mb_strtolower(trim(preg_replace('/\s+/u',' ',str_replace("\xC2\xA0",' ',$value)) ?? '')); }
}
