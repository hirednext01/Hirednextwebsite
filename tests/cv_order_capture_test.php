<?php
declare(strict_types=1);
require __DIR__.'/cv_fulfilment_delivery_test.php';
require __DIR__.'/../app/Services/Cv/Automation/CvFulfilmentCapture.php';
$orders->order['name']='Synthetic Candidate';
$before=$store->read('order:'.$order['key']);
$capture=$service->dispatch($request+['action'=>'capture','to'=>'wrong@example.test']);
check($capture['status']==='capture_reserved' && $capture['handoff']['to']==='jobs@hirednext.info','order capture reserves a fixed internal destination');
check(str_contains($capture['handoff']['text'],$request['access']),'private capability appears only in the internal handoff');
$again=$service->dispatch($request+['action'=>'capture']);
check(!isset($again['handoff']),'replayed capture cannot emit a second email');
rejects(fn()=>$service->dispatch($request+['action'=>'capture_receipt','gmail_message_id'=>'invented']),'capture_receipt_required');
$receipt=$service->dispatch($request+['action'=>'capture_receipt','gmail_message_id'=>'abcdef123456']);
check($receipt['status']==='captured','capture records the native Gmail receipt');
check($service->dispatch($request+['action'=>'capture'])['status']==='captured','completed capture stays deduplicated');
check($store->read('order:'.$order['key'])===$before,'capture does not alter payment or delivery state');
echo "All native order capture checks passed.\n";
