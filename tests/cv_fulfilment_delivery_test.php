<?php
declare(strict_types=1);
use App\Services\Cv\Automation\CvFulfilmentAccess as Access;
require __DIR__.'/cv_automatic_fulfilment_test.php';
foreach (['CvFulfilmentStore','CvFulfilmentOrders','CvFulfilmentMailer','CvFulfilmentService'] as $class) {
    $file=__DIR__.'/../app/Services/Cv/Automation/'.$class.'.php';
    check(is_file($file),$class.' exists'); require_once $file;
}
class TestOrders extends \App\Services\Cv\Automation\CvFulfilmentOrders {
    public array $order; public string $text; public int $completed=0;
    public function load(string $key): array { return $this->order; }
    public function source(array $order): array { return ['sha256'=>hash('sha256',$this->text),'text'=>$this->text,'filename'=>'cv.txt','base64'=>base64_encode($this->text)]; }
    public function duplicateReference(array $order): ?string { return null; }
    public function hasExistingWork(array $order): bool { return false; }
    public function payment(array $order,array $proof): void { $this->order['payment_status']='owner_confirmed'; }
    public function delivered(array $order,array $report,array $receipt): void { $this->completed++; }
    public function event(array $order,string $event,array $data): void {}
}
class TestMailer extends \App\Services\Cv\Automation\CvFulfilmentMailer {
    public int $calls=0; public bool $fail=false;
    public function deliver(array $order,string $path,string $deliveryId): array {
        $this->calls++; if ($this->fail) { throw new RuntimeException('simulated SMTP timeout'); }
        return ['accepted'=>true,'message_id'=>'<test@example.test>','delivery_id'=>$deliveryId];
    }
}
$directory=sys_get_temp_dir().'/hn-fulfilment-test-'.bin2hex(random_bytes(8));
$store=new \App\Services\Cv\Automation\CvFulfilmentStore($directory);
$orders=new TestOrders(); $orders->order=$order; $orders->text=$source;
$mailer=new TestMailer();
$service=new \App\Services\Cv\Automation\CvFulfilmentService($store,$orders,$mailer);
$token=Access::sign($order,$store->secret(),time()+300);
$request=['order_key'=>$order['key'],'access'=>$token];
rejects(fn()=>$service->dispatch($request+['action'=>'claim']),'payment_unconfirmed');
$service->dispatch($request+['action'=>'confirm_owner','proof'=>['type'=>'owner_confirmed','reference'=>$order['reference'],'amount'=>599,'source'=>'chat:explicit-owner-confirmation']]);
$claimed=$service->dispatch($request+['action'=>'claim']);
check(isset($claimed['lease']), 'confirmed order receives an exclusive delivery lease');
rejects(fn()=>$service->dispatch($request+['action'=>'claim']),'already_processing');
$delivery=$request+['action'=>'deliver','lease'=>$claimed['lease'],'report'=>$report,'pdf_base64'=>base64_encode($pdf)];
$result=$service->dispatch($delivery);
check($result['status']==='delivered' && $mailer->calls===1 && $orders->completed===1,'confirmed report is sent and recorded once');
$again=$service->dispatch($delivery);
check($again['status']==='already_delivered' && $mailer->calls===1,'repeated delivery cannot send another email');
check($service->dispatch($request+['action'=>'claim'])['status']==='already_delivered','repeated claim cannot regenerate delivered report');

$orders2=new TestOrders(); $orders2->order=array_replace($order,['key'=>'assessment:82','lead_id'=>82,'reference'=>'UPI222222222']); $orders2->text=$source;
$mailer2=new TestMailer(); $mailer2->fail=true;
$service2=new \App\Services\Cv\Automation\CvFulfilmentService($store,$orders2,$mailer2);
$request2=['order_key'=>$orders2->order['key'],'access'=>Access::sign($orders2->order,$store->secret(),time()+300)];
$service2->dispatch($request2+['action'=>'confirm_owner','proof'=>['type'=>'owner_confirmed','reference'=>'UPI222222222','amount'=>599,'source'=>'chat:explicit-owner-confirmation']]);
$claim2=$service2->dispatch($request2+['action'=>'claim']);
$report2=$report; $report2['delivery_id']='HN-CV-ASSESSMENT-82';
$manifest2=$manifest; $manifest2[2]=$report2['delivery_id'];
$digest2=hash('sha256',json_encode($manifest2,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR));
$pdf2=str_replace($digest,$digest2,$pdf);
$delivery2=$request2+['action'=>'deliver','lease'=>$claim2['lease'],'report'=>$report2,'pdf_base64'=>base64_encode($pdf2)];
rejects(fn()=>$service2->dispatch($delivery2),'delivery_reconciliation_required');
rejects(fn()=>$service2->dispatch($delivery2),'delivery_reconciliation_required');
check($mailer2->calls===1 && $orders2->completed===0,'uncertain SMTP result blocks replay and completion claims');
echo "All automatic delivery behaviour checks passed.\n";
