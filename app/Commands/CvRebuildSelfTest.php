<?php
declare(strict_types=1);
namespace App\Commands;

use App\Services\Cv\Automation\CvFulfilmentAccess;
use App\Services\Cv\Automation\CvFulfilmentOrders;
use App\Services\Cv\Automation\CvFulfilmentStore;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CvRebuildSelfTest extends BaseCommand
{
    protected $group='HiredNext';
    protected $name='cv:rebuild-self-test';
    protected $description='Issue one zero-value fictional rebuild fixture to jobs only; never confirms or contacts a customer.';
    public function run(array $params)
    {
        $store=new CvFulfilmentStore();
        $store->locked(function() use ($store,$params): void {
            $fixture=$store->read('rebuild-fixture:v1');
            if (in_array('sealed',$params,true) && isset($fixture['order_key']) && !isset($fixture['sealed_test_access_at'])) {
                $testOrder=(new CvFulfilmentOrders())->load($fixture['order_key']);
                if (!$testOrder['is_test'] || $testOrder['amount']!==0 || $testOrder['service']!=='rebuild_1799' || $testOrder['email']!=='jobs@hirednext.info') { throw new \RuntimeException('Only the zero-value internal rebuild fixture may use diagnostic transport.'); }
                $publicKey=(string)file_get_contents(ROOTPATH.'tests/fixtures/rebuild-test-public.pem');
                $payload=json_encode(['order_key'=>$testOrder['key'],'access'=>CvFulfilmentAccess::issue($testOrder)],JSON_THROW_ON_ERROR);
                if (!openssl_public_encrypt($payload,$sealed,$publicKey,OPENSSL_PKCS1_OAEP_PADDING)) { throw new \RuntimeException('Encrypted fixture transport unavailable.'); }
                CLI::write('INTERNAL_FIXTURE_SEALED:'.base64_encode($sealed));
                CLI::write('Configured mail transport: '.\Config\Services::email()->protocol);
                $fixture['sealed_test_access_at']=gmdate('c'); $store->write('rebuild-fixture:v1',$fixture);
            }
            if (isset($fixture['email_attempted_at'])) { CLI::write('Internal rebuild fixture already attempted: '.$fixture['order_key']); return; }
            if (!class_exists(\ZipArchive::class)) { throw new \RuntimeException('Rebuild DOCX export unavailable.'); }
            $db=db_connect();
            foreach (['cv_assessment_leads','cv_upgrade_orders','cv_documents','cv_report_versions','cv_review_events','cv_email_events'] as $table) {
                if (!$db->tableExists($table)) { throw new \RuntimeException('Rebuild table missing: '.$table); }
            }
            if (!isset($fixture['order_key'])) {
                $input=json_decode((string)file_get_contents(ROOTPATH.'tests/fixtures/cv_automation_assessment.json'),true,32,JSON_THROW_ON_ERROR);
                $directory=WRITEPATH.'uploads/cv-assessments';
                if (!is_dir($directory) && !mkdir($directory,0750,true)) { throw new \RuntimeException('Fixture storage unavailable.'); }
                $filename='internal-rebuild-'.bin2hex(random_bytes(8)).'.txt';
                if (file_put_contents($directory.'/'.$filename,$input['source_text'])!==strlen($input['source_text'])) { throw new \RuntimeException('Fixture source write failed.'); }
                $now=date('Y-m-d H:i:s');
                $db->transBegin();
                try {
                    if (!$db->table('cv_assessment_leads')->insert(['name'=>$input['candidate_name'],'email'=>'jobs@hirednext.info','phone'=>'0000000000','assessment_plan'=>'automation_test_1799','job_title'=>'Operations Head','message'=>'INTERNAL TEST ONLY. No customer, demand or revenue.','resume_path'=>'writable/uploads/cv-assessments/'.$filename,'amount'=>0,'payment_status'=>'internal_test','payment_id'=>'HNTEST-REBUILD-V1','status'=>'internal_test','created_at'=>$now,'updated_at'=>$now])) { throw new \RuntimeException('Fixture lead failed.'); }
                    $leadId=(int)$db->insertID();
                    if (!$db->table('cv_upgrade_orders')->insert(['lead_id'=>$leadId,'token'=>bin2hex(random_bytes(24)),'tier'=>'rebuild_1799','service_name'=>'INTERNAL TEST ONLY: CV Rebuild','amount'=>0,'status'=>'internal_test','payment_reference'=>'HNTEST-REBUILD-V1','submitted_at'=>$now,'created_at'=>$now,'updated_at'=>$now])) { throw new \RuntimeException('Fixture upgrade failed.'); }
                    $fixture=['order_key'=>'upgrade:'.(int)$db->insertID(),'created_at'=>gmdate('c')];
                    $db->transCommit();
                } catch (\Throwable $e) { $db->transRollback(); throw $e; }
                $store->write('rebuild-fixture:v1',$fixture);
            }
            $order=(new CvFulfilmentOrders())->load($fixture['order_key']);
            $mail=\Config\Services::email(); $mail->clear(true);
            $mail->setFrom('jobs@hirednext.info','HiredNext Automation'); $mail->setTo('jobs@hirednext.info');
            $mail->setSubject('INTERNAL TEST: HiredNext rebuild automation handoff | '.$order['key']); $mail->setMailType('text');
            $mail->setMessage("INTERNAL TEST ONLY. Zero money received. Exclude from customers, demand, sales and revenue.\nOrder: ".$order['key']."\nAmount: INR 0\nReference: HNTEST-REBUILD-V1\n\nSYNTHETIC ANSWERS FOR CONTROLLED TEST\nThe 18 people were direct reports. I reported to the Plant Director. I do not have a confirmed measurement period or budget figure. Keep the stated 82% to 94% dispatch result without claiming a cause. Use the Classic and Leadership directions.\nEND SYNTHETIC ANSWERS\n".CvFulfilmentAccess::notice($order));
            $fixture['email_attempted_at']=gmdate('c'); $store->write('rebuild-fixture:v1',$fixture);
            if (!$mail->send(false)) { throw new \RuntimeException('Internal fixture email needs reconciliation; no automatic retry.'); }
            $fixture['email_sent']=true; $store->write('rebuild-fixture:v1',$fixture);
            CLI::write('Internal rebuild fixture issued to jobs: '.$order['key'].'. No payment or customer send.');
        });
    }
}
