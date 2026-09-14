<?php
declare(strict_types=1);
namespace App\Commands;

use App\Services\Cv\Automation\CvFulfilmentAccess;
use App\Services\Cv\Automation\CvFulfilmentOrders;
use App\Services\Cv\Automation\CvFulfilmentStore;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CvAutomationSelfTest extends BaseCommand
{
    protected $group='HiredNext';
    protected $name='cv:automation-self-test';
    protected $description='Create one zero-value internal CV automation fixture and email its private handoff to jobs. Never confirms a real payment or sends to a customer.';
    public function run(array $params)
    {
        $store=new CvFulfilmentStore();
        $store->locked(function() use ($store): void {
            $fixture=$store->read('fixture:v1');
            if (($fixture['email_sent'] ?? false)===true) { CLI::write('Internal CV automation fixture already issued: '.$fixture['order_key']); return; }
            $db=db_connect();
            foreach (['cv_assessment_leads','cv_report_versions','cv_review_events','cv_email_events'] as $table) {
                if (!$db->tableExists($table)) { throw new \RuntimeException('CV automation table missing: '.$table); }
            }
            if (!isset($fixture['order_key'])) {
                $directory=WRITEPATH.'uploads/cv-assessments';
                if (!is_dir($directory) && !mkdir($directory,0750,true)) { throw new \RuntimeException('CV fixture directory unavailable.'); }
                $source="INTERNAL TEST ONLY - FICTIONAL CV - NO CUSTOMER OR SALE\nHiredNext Internal Automation Test\nTarget: Operations Head\n\nOperations Manager, Example Manufacturing, April 2021 - present. Led a team of 18 people across two production sites. Improved on-time dispatch from 82% to 94%. Responsible for production scheduling, vendor coordination and weekly reporting. Introduced a daily dispatch review.\n\nProduction Coordinator, Sample Textiles, June 2017 - March 2021. Prepared production plans and followed up with vendors. Maintained weekly production and quality reports.\n\nEducation: Bachelor of Commerce, 2017. Skills: Excel, production planning, vendor coordination, reporting.\n\nNo budget size, cost reduction value, ERP platform, or management reporting line is stated. These details must not be invented.\n";
                $name='internal-automation-'.bin2hex(random_bytes(8)).'.txt';
                if (file_put_contents($directory.'/'.$name,$source)!==strlen($source)) { throw new \RuntimeException('CV fixture write failed.'); }
                $now=date('Y-m-d H:i:s');
                $ok=$db->table('cv_assessment_leads')->insert(['name'=>'HiredNext Internal Automation Test','email'=>'jobs@hirednext.info','phone'=>'0000000000','assessment_plan'=>'automation_test_599','job_title'=>'Operations Head','message'=>'INTERNAL TEST ONLY. Exclude from demand, sales and revenue. No real payment.','resume_path'=>'writable/uploads/cv-assessments/'.$name,'amount'=>0,'payment_status'=>'internal_test','payment_id'=>'HNTEST-AUTOMATION-V1','status'=>'internal_test','created_at'=>$now,'updated_at'=>$now]);
                if (!$ok) { throw new \RuntimeException('CV fixture record failed.'); }
                $fixture=['order_key'=>'assessment:'.(int)$db->insertID(),'email_sent'=>false,'created_at'=>gmdate('c')];
                $store->write('fixture:v1',$fixture);
            }
            $order=(new CvFulfilmentOrders())->load($fixture['order_key']);
            $email=\Config\Services::email(); $email->clear(true);
            $email->setFrom('jobs@hirednext.info','HiredNext Automation'); $email->setTo('jobs@hirednext.info');
            $email->setSubject('INTERNAL TEST: HiredNext CV automation handoff | '.$order['key']); $email->setMailType('text');
            $email->setMessage("INTERNAL TEST ONLY. Zero money received; exclude from sales, demand and revenue.\nOrder: ".$order['key']."\nService: Priority CV Assessment test\nAmount: INR 0\nReference: HNTEST-AUTOMATION-V1\n".CvFulfilmentAccess::notice($order));
            $email->attach(ROOTPATH.$order['resume_path']);
            if (!$email->send(false)) { throw new \RuntimeException('Internal CV handoff email unconfirmed.'); }
            $fixture['email_sent']=true; $store->write('fixture:v1',$fixture);
            CLI::write('Internal CV automation fixture issued to jobs: '.$fixture['order_key'].'. No payment or customer send.');
        });
    }
}
