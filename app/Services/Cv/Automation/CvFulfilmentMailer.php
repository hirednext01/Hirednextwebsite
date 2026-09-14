<?php
declare(strict_types=1);
namespace App\Services\Cv\Automation;

use App\Models\CvEmailEventModel;

class CvFulfilmentMailer
{
    public function deliver(array $order,string $path,string $deliveryId): array
    {
        if (!filter_var($order['email'],FILTER_VALIDATE_EMAIL) || ($order['is_test'] && $order['email']!=='jobs@hirednext.info')) { throw new \DomainException('recipient_invalid'); }
        $pdf=is_readable($path)?file_get_contents($path):false;
        if ($pdf===false || !str_starts_with($pdf,'%PDF-')) { throw new \RuntimeException('pdf_attachment_unreadable'); }
        $subject=($order['is_test']?'INTERNAL TEST | ':'').'Your HiredNext CV Assessment | '.$deliveryId;
        $event=(new CvEmailEventModel())->recordAttempt($order['lead_id'],'automatic_report_delivery',$order['email'],$subject);
        if (!$event) { throw new \RuntimeException('email_audit_unavailable'); }
        $email=\Config\Services::email(); $email->clear(true);
        $email->setFrom('jobs@hirednext.info','HiredNext Recruitment');
        $email->setTo($order['email']);
        if ($order['email']!=='jobs@hirednext.info') { $email->setBCC('jobs@hirednext.info'); }
        $email->setReplyTo('jobs@hirednext.info','HiredNext Recruitment');
        $email->setSubject($subject); $email->setMailType('text');
        $body="Dear ".$order['name'].",\n\nYour three-page CV assessment is attached. It covers your positioning, evidence and role language, followed by the priority improvements.\n\nIf a detail needs correcting, reply to this email and identify the section. Please retain the report reference: ".$deliveryId.".\n\nThis professional CV service is optional and does not guarantee a job, interview or shortlist.\n\nRegards,\nHiredNext Recruitment\nhttps://hirednext.net\n";
        if ($order['is_test']) { $body="INTERNAL AUTOMATION TEST. No payment was received. Exclude this order from sales, demand and revenue counts.\n\n".$body; }
        // With an explicit MIME type CodeIgniter expects buffered bytes, not a path.
        $email->setMessage($body); $email->attach($pdf,'attachment',$deliveryId.'.pdf','application/pdf');
        $accepted=$email->send(false);
        if (!$accepted) {
            (new CvEmailEventModel())->markFailed($event,'SMTP result unconfirmed; reconcile the delivery reference before any retry.');
            throw new \RuntimeException('smtp_result_unconfirmed');
        }
        $messageId=method_exists($email,'getHeader') ? (string)$email->getHeader('Message-ID') : '';
        (new CvEmailEventModel())->markSent($event,$messageId?:null);
        return ['accepted'=>true,'message_id'=>$messageId?:null,'delivery_id'=>$deliveryId,'email_event_id'=>$event,'pdf_sha256'=>hash('sha256',$pdf),'pdf_bytes'=>strlen($pdf),'smtp_accepted_at'=>gmdate('c')];
    }
}
