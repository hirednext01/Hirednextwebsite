<?php
declare(strict_types=1);
namespace App\Commands;

use App\Services\Cv\Automation\CvFulfilmentCapture;
use App\Services\Cv\Automation\CvFulfilmentOrders;
use App\Services\Cv\Automation\CvFulfilmentStore;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CvNativeCaptureSelfTest extends BaseCommand
{
    protected $group='HiredNext';
    protected $name='cv:native-capture-self-test';
    protected $description='Verify one fictional zero-value website-to-jobs native handoff, with no customer send.';
    public function run(array $params)
    {
        $store=new CvFulfilmentStore();
        $fixture=$store->locked(function() use($store): array {
            $f=$store->read('fixture:native-capture-v1'); if ($f) { return $f; }
            $input=json_decode((string)file_get_contents(ROOTPATH.'tests/fixtures/cv_automation_assessment.json'),true,32,JSON_THROW_ON_ERROR);
            $name='internal-native-capture-'.bin2hex(random_bytes(8)).'.txt'; $path=WRITEPATH.'uploads/cv-assessments/'.$name;
            if (file_put_contents($path,$input['source_text'])!==strlen($input['source_text'])) { throw new \RuntimeException('Native fixture source failed.'); }
            $db=db_connect(); $now=date('Y-m-d H:i:s');
            if (!$db->table('cv_assessment_leads')->insert(['name'=>$input['candidate_name'],'email'=>'jobs@hirednext.info','phone'=>'0000000000','assessment_plan'=>'automation_test_599','job_title'=>'Operations Head','message'=>'INTERNAL TEST ONLY. No candidate, payment, demand or revenue.','resume_path'=>'writable/uploads/cv-assessments/'.$name,'amount'=>0,'payment_status'=>'internal_test','payment_id'=>'HNTEST-NATIVE-CAPTURE-V1','status'=>'internal_test','created_at'=>$now,'updated_at'=>$now])) { throw new \RuntimeException('Native fixture record failed.'); }
            $f=['order_key'=>'assessment:'.(int)$db->insertID()]; $store->write('fixture:native-capture-v1',$f); return $f;
        });
        if (isset($fixture['verified_at'])) { CLI::write('Native CV capture already verified: '.$fixture['order_key']); return; }
        $order=(new CvFulfilmentOrders())->load($fixture['order_key']);
        if (!$order['is_test'] || $order['amount']!==0 || $order['email']!=='jobs@hirednext.info') { throw new \RuntimeException('Internal fixture required.'); }
        // Release the local journal lock before the relay calls the website back.
        CvFulfilmentCapture::relay($order);
        $fixture['verified_at']=gmdate('c'); $store->locked(fn()=>$store->write('fixture:native-capture-v1',$fixture));
        CLI::write('Native website-to-jobs handoff verified: '.$order['key'].'. Zero customer sends and zero cash receipts.');
    }
}
