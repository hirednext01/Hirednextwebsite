<?php
declare(strict_types=1);
namespace App\Commands;

use App\Services\HiredNextEmail;
use App\Services\Cv\Automation\CvFulfilmentStore;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CandidateEmailStylePreview extends BaseCommand
{
    protected $group='HiredNext';
    protected $name='cv:email-style-preview';
    protected $description='Send one internal candidate email typography preview to jobs only.';
    public function run(array $params)
    {
        $store=new CvFulfilmentStore();
        $store->locked(function() use ($store): void {
            if ($store->read('email-style:v1')) { CLI::write('Candidate email style preview already attempted.'); return; }
            $mail=\Config\Services::email(); $mail->clear(true);
            $mail->setFrom('jobs@hirednext.info','HiredNext Recruitment');
            $mail->setTo('jobs@hirednext.info');
            $mail->setReplyTo('jobs@hirednext.info','HiredNext Recruitment');
            $mail->setSubject('INTERNAL TEST | HiredNext candidate email style | HN-EMAIL-STYLE-1');
            HiredNextEmail::applyText($mail,'A clearer picture of your experience',"Dear Candidate,\n\nYour experience deserves a clear first impression. We will use the facts in your CV to explain what a hiring manager can understand immediately, where the evidence needs strengthening, and which changes will make the document easier to read.\n\nYour next step\nReply in the same email thread if a detail needs correcting. Your career facts remain the foundation of the work.\n\nRegards,\nHiredNext Recruitment\n\nINTERNAL STYLE PREVIEW ONLY. No candidate, order or payment is associated with this message.");
            $store->write('email-style:v1',['attempted_at'=>gmdate('c'),'is_test'=>true]);
            if (!$mail->send(false)) { throw new \RuntimeException('Internal style preview delivery unconfirmed.'); }
            $store->write('email-style:v1',['sent_at'=>gmdate('c'),'is_test'=>true]);
            CLI::write('Branded candidate email preview sent to jobs.');
        });
    }
}
