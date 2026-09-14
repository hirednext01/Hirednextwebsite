<?php
declare(strict_types=1);
namespace App\Services\Cv\Automation;

class CvFulfilmentService
{
    public function __construct(private ?CvFulfilmentStore $store=null,private ?CvFulfilmentOrders $orders=null,private ?CvFulfilmentMailer $mailer=null)
    {
        $this->store ??= new CvFulfilmentStore(); $this->orders ??= new CvFulfilmentOrders(); $this->mailer ??=new CvFulfilmentMailer();
    }
    public function dispatch(array $request): array
    {
        $key=(string)($request['order_key'] ?? '');
        $order=$this->orders->load($key);
        if (!CvFulfilmentAccess::valid($order,(string)($request['access'] ?? ''),$this->store->secret(),time())) { throw new \DomainException('access_denied'); }
        if (in_array($request['action'] ?? '',['capture','capture_receipt','relay_capture'],true)) { return CvFulfilmentCapture::handle($this->store,$order,$request); }
        if ($order['service']==='rebuild_1799') { return (new CvRebuildService($this->store,$this->orders))->dispatch($order,$request); }
        return $this->store->locked(function() use ($request,$order,$key): array {
            $state=$this->store->read('order:'.$key);
            $state += ['order_key'=>$key,'status'=>'awaiting_payment','is_test'=>$order['is_test'],'external_api_cash_cost_inr'=>0];
            $action=(string)($request['action'] ?? 'inspect');
            if ($action==='inspect') { return $this->snapshot($order,$state); }
            if ($action==='source') {
                if (!in_array($state['status'],['ready','processing','delivered'],true)) { throw new \DomainException('payment_unconfirmed'); }
                return ['order_key'=>$key,'source'=>$this->orders->source($order)];
            }
            if (in_array($action,['confirm_owner','confirm_test'],true)) {
                if (($action==='confirm_test')!==$order['is_test']) { throw new \DomainException('owner_confirmation_required'); }
                if (($state['payment']['status'] ?? '')!=='' && !in_array($state['status'],['awaiting_payment','exception'],true)) { return $this->snapshot($order,$state); }
                $references=$this->store->read('payment-references');
                $referenceHash=hash('sha256',CvFulfilmentPolicy::reference($order['reference']));
                $usedBy=$references[$referenceHash] ?? $this->orders->duplicateReference($order);
                $proof=CvFulfilmentPolicy::payment($order,(array)($request['proof'] ?? []),$usedBy);
                if ($this->orders->hasExistingWork($order)) { throw new \DomainException('existing_delivery_owner'); }
                $references[$referenceHash]=$key; $this->store->write('payment-references',$references);
                $this->orders->payment($order,$proof);
                $state['payment']=$proof; $state['status']='ready'; $state['updated_at']=gmdate('c');
                $this->store->write('order:'.$key,$state);
                return $this->snapshot($order,$state);
            }
            if ($action==='claim') {
                if ($order['service']!=='priority_599') { throw new \DomainException('existing_service_owner_required'); }
                if (CvFulfilmentPolicy::claim($state,time())==='already_delivered') { return ['status'=>'already_delivered','delivery'=>$state['delivery'] ?? []]; }
                if ($this->orders->hasExistingWork($order)) { throw new \DomainException('existing_delivery_owner'); }
                $source=$this->orders->source($order); $lease=bin2hex(random_bytes(24));
                $state['status']='processing'; $state['lease_hash']=hash('sha256',$lease); $state['lease_expires_at']=time()+3600; $state['source_sha256']=$source['sha256'];
                $this->store->write('order:'.$key,$state);
                return ['status'=>'processing','lease'=>$lease,'source_sha256'=>$source['sha256'],'order'=>$this->publicOrder($order),'delivery_id'=>$this->deliveryId($order)];
            }
            if ($action==='deliver') { return $this->deliver($order,$state,$request); }
            if ($action==='reconcile') {
                if ($state['status']==='delivered') { return ['status'=>'already_delivered','delivery'=>$state['delivery'] ?? []]; }
                if ($state['status']!=='delivery_uncertain' || !preg_match('/^[a-f0-9]{12,40}$/i',(string)($request['gmail_message_id'] ?? '')) || ($request['delivery_id'] ?? '')!==($state['delivery_id'] ?? '') || ($request['recipient'] ?? '')!==$order['email']) { throw new \DomainException('delivery_receipt_required'); }
                $saved=$this->store->read('report:'.$key); $receipt=['accepted'=>true,'delivery_id'=>$state['delivery_id'],'gmail_message_id'=>$request['gmail_message_id'],'reconciled_at'=>gmdate('c')];
                $this->orders->delivered($order,$saved,$receipt);
                $state['status']='delivered'; $state['delivery']=$receipt; $this->store->write('order:'.$key,$state);
                return ['status'=>'delivered','delivery'=>$receipt,'is_test'=>$order['is_test']];
            }
            if ($action==='exception') {
                $code=(string)($request['code'] ?? '');
                if (!preg_match('/^[a-z_]{4,60}$/',$code)) { throw new \DomainException('exception_code_required'); }
                $state['exception']=['code'=>$code,'at'=>gmdate('c')];
                // Keep delivery_uncertain/delivered immutable: an exception cannot reopen a send.
                $this->store->write('order:'.$key,$state);
                return ['status'=>$state['status'],'exception'=>$state['exception']];
            }
            throw new \DomainException('unknown_action');
        });
    }

    private function deliver(array $order,array $state,array $request): array
    {
        if ($state['status']==='delivered') { return ['status'=>'already_delivered','delivery'=>$state['delivery'] ?? []]; }
        if ($state['status']==='delivery_uncertain') { throw new \DomainException('delivery_reconciliation_required'); }
        if ($order['service']!=='priority_599' || $state['status']!=='processing' || ($state['lease_expires_at'] ?? 0)<time() || !hash_equals((string)($state['lease_hash'] ?? ''),hash('sha256',(string)($request['lease'] ?? '')))) { throw new \DomainException('valid_delivery_lease_required'); }
        $source=$this->orders->source($order);
        if (!hash_equals($state['source_sha256'],$source['sha256'])) { throw new \DomainException('source_changed'); }
        $report=(array)($request['report'] ?? []);
        if (($report['delivery_id'] ?? '')!==$this->deliveryId($order)) { throw new \DomainException('report_order_mismatch'); }
        if (($report['candidate_name'] ?? '')!==($order['name'] ?? $report['candidate_name'] ?? '')) { throw new \DomainException('candidate_mismatch'); }
        $pdf=base64_decode((string)($request['pdf_base64'] ?? ''),true);
        if ($pdf===false) { throw new \DomainException('three_page_pdf_required'); }
        $sourceText=$source['text'] ?: (string)($report['source_text'] ?? '');
        CvFulfilmentPolicy::report($report,$source['sha256'],$sourceText,$pdf);
        if ($this->orders->hasExistingWork($order)) { throw new \DomainException('existing_delivery_owner'); }
        $deliveryId=$this->deliveryId($order); $report['delivery_id']=$deliveryId;
        $path=$this->store->put('pdf:'.$order['key'],$pdf); $this->store->write('report:'.$order['key'],$report);
        // Persist before the irreversible SMTP operation. A crash or timeout after
        // this point requires mailbox reconciliation, never another blind send.
        $state['status']='delivery_uncertain'; $state['delivery_id']=$deliveryId; $state['delivery_attempted_at']=gmdate('c'); $state['pdf_sha256']=hash('sha256',$pdf);
        $this->store->write('order:'.$order['key'],$state);
        try {
            $receipt=$this->mailer->deliver($order,$path,$deliveryId);
            $this->orders->delivered($order,$report,$receipt);
            $state['status']='delivered'; $state['delivery']=$receipt; $state['delivered_at']=gmdate('c');
            $this->store->write('order:'.$order['key'],$state);
            return ['status'=>'delivered','delivery'=>$receipt,'cash_received_inr'=>$state['payment']['cash_received_inr'] ?? null,'is_test'=>$order['is_test']];
        } catch (\Throwable $e) {
            $this->orders->event($order,'automatic_delivery_uncertain',['delivery_id'=>$deliveryId]);
            throw new \DomainException('delivery_reconciliation_required');
        }
    }
    private function snapshot(array $order,array $state): array
    {
        unset($state['lease_hash']);
        return ['order'=>$this->publicOrder($order),'fulfilment'=>$state,'supported_for_delivery'=>$order['service']==='priority_599'];
    }
    private function publicOrder(array $order): array { unset($order['resume_path']); return $order; }
    private function deliveryId(array $order): string { return 'HN-CV-'.strtoupper(str_replace(':','-',$order['key'])); }
}
