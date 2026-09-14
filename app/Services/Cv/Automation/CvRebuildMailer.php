<?php
declare(strict_types=1);
namespace App\Services\Cv\Automation;

use App\Models\CvEmailEventModel;
use App\Services\HiredNextEmail;

class CvRebuildMailer
{
    public function send(array $order,string $stageId,string $title,string $body,array $files=[]): array
    {
        if (!filter_var($order['email'],FILTER_VALIDATE_EMAIL) || ($order['is_test'] && $order['email']!=='jobs@hirednext.info')) { throw new \DomainException('recipient_invalid'); }
        $base='HN-CV-REBUILD-'.strtoupper(str_replace(':','-',$order['key']));
        $subject=($order['is_test']?'INTERNAL TEST | ':'').'Your HiredNext CV Rebuild | '.$base;
        $audit=new CvEmailEventModel(); $event=$audit->recordAttempt($order['lead_id'],'automatic_rebuild_message',$order['email'],$subject);
        if (!$event) { throw new \RuntimeException('email_audit_unavailable'); }
        $mail=\Config\Services::email(); $mail->clear(true);
        $mail->setFrom('jobs@hirednext.info','HiredNext Recruitment'); $mail->setTo($order['email']);
        if ($order['email']!=='jobs@hirednext.info') { $mail->setBCC('jobs@hirednext.info'); }
        $mail->setReplyTo('jobs@hirednext.info','HiredNext Recruitment'); $mail->setSubject($subject);
        $text='Dear '.$order['name'].",\n\n".$body."\n\nReference: ".$stageId."\n\nRegards,\nHiredNext Recruitment";
        if ($order['is_test']) { $text.="\n\nINTERNAL AUTOMATION TEST ONLY. No real candidate, payment or sale."; }
        HiredNextEmail::applyText($mail,$title,$text);
        $attachments=[];
        foreach ($files as $file) {
            if (!preg_match('/^HN-CV-[A-Z0-9-]+\.(pdf|docx)$/',$file['name'])) { throw new \DomainException('attachment_name_invalid'); }
            $mail->attach($file['bytes'],'attachment',$file['name'],$file['mime']);
            $attachments[]=['name'=>$file['name'],'bytes'=>strlen($file['bytes']),'sha256'=>hash('sha256',$file['bytes'])];
        }
        if (!$mail->send(false)) { $audit->markFailed($event,'Reconcile exact stage before retrying.'); throw new \RuntimeException('delivery_unconfirmed'); }
        $audit->markSent($event,null);
        return ['accepted'=>true,'stage_id'=>$stageId,'recipient'=>$order['email'],'email_event_id'=>$event,'attachments'=>$attachments,'accepted_at'=>gmdate('c')];
    }
}
