<?php
declare(strict_types=1);
namespace App\Services\Cv\Automation;

/** Order-bound native mail handoff. Capture never confirms payment. */
final class CvFulfilmentCapture
{
    public static function relay(array $order): array
    {
        $response=\Config\Services::curlrequest(['timeout'=>20,'connect_timeout'=>5])->post('https://tarushikha.app.n8n.cloud/webhook/hirednext-cv-capture',[
            'json'=>['order_key'=>$order['key'],'access'=>CvFulfilmentAccess::issue($order)],'http_errors'=>false,'allow_redirects'=>false,
        ]);
        $data=json_decode((string)$response->getBody(),true);
        if ($response->getStatusCode()!==200 || !is_array($data) || ($data['status'] ?? '')!=='captured') { throw new \RuntimeException('native_capture_unconfirmed'); }
        return ['status'=>'captured','order_key'=>$order['key']];
    }

    /** Called only after the existing order capability has been authenticated. */
    public static function handle(CvFulfilmentStore $store,array $order,array $request): array
    {
        if ($request['action']==='relay_capture') { return self::relay($order); }
        return $store->locked(function() use($store,$order,$request): array {
            $key='capture:'.$order['key'].':'.hash('sha256',CvFulfilmentPolicy::reference($order['reference']));
            $state=$store->read($key);
            if ($request['action']==='capture_receipt') {
                $id=(string)($request['gmail_message_id'] ?? '');
                if (!$state || !preg_match('/^[a-f0-9]{12,40}$/i',$id)) { throw new \DomainException('capture_receipt_required'); }
                if (($state['status'] ?? '')==='captured') { return ['status'=>'captured','order_key'=>$order['key']]; }
                $state['status']='captured'; $state['gmail_message_id']=$id; $state['captured_at']=gmdate('c'); $store->write($key,$state);
                return ['status'=>'captured','order_key'=>$order['key']];
            }
            if ($state) { return ['status'=>$state['status'],'order_key'=>$order['key']]; }
            $stage='HN-ORDER-CAPTURE-'.strtoupper(str_replace(':','-',$order['key']));
            $subject=($order['is_test']?'INTERNAL TEST | ':'').'ACTION: CV payment/reference received | '.$order['key'];
            $text="INTERNAL AUTOMATION HANDOFF — DO NOT FORWARD\n\nCandidate: ".$order['name']."\nEmail: ".$order['email']."\nService: ".$order['service']."\nAmount: INR ".$order['amount']."\nReference: ".$order['reference']."\n\nThis records a submitted order/reference, not confirmed payment. Use the existing exact confirmation, then proceed to the purchased service without a second approval.\n\nAutomation order: ".$order['key']."\nAutomation access: ".$request['access']."\nStage: ".$stage."\n";
            if ($order['is_test']) { $text.="\nINTERNAL TEST ONLY. No customer, payment, sale or revenue.\n"; }
            $store->write($key,['status'=>'capture_reserved','order_key'=>$order['key'],'stage_id'=>$stage,'reserved_at'=>gmdate('c'),'is_test'=>$order['is_test']]);
            return ['status'=>'capture_reserved','order_key'=>$order['key'],'handoff'=>['to'=>'jobs@hirednext.info','subject'=>$subject,'text'=>$text]];
        });
    }
}
