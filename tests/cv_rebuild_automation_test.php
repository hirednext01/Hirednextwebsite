<?php
declare(strict_types=1);
require __DIR__.'/cv_automatic_fulfilment_test.php';
$path=__DIR__.'/../app/Services/Cv/Automation/CvRebuildPolicy.php';
check(is_file($path),'rebuild policy exists'); require_once $path;
use App\Services\Cv\Automation\CvRebuildPolicy as Rebuild;
$rebuildOrder=array_replace($order,['service'=>'rebuild_1799','amount'=>1799]);
$paid=\App\Services\Cv\Automation\CvFulfilmentPolicy::payment($rebuildOrder,['type'=>'owner_confirmed','amount'=>1799,'reference'=>$order['reference'],'source'=>'Owner confirmed the exact rebuild order in this conversation'],null);
check($paid['cash_received_inr']===1799,'exact rebuild payment is supported');
rejects(fn()=>Rebuild::templates(['ats_classic','ats_classic']),'two_distinct_templates_required');
check(Rebuild::templates(['ats_classic','executive_ats'])===['ats_classic','executive_ats'],'two approved design directions are retained');
rejects(fn()=>Rebuild::reply($rebuildOrder,['sender_email'=>'other@example.test','gmail_message_id'=>'abcdef123456','text'=>'Please correct the current role details.']),'candidate_reply_required');
$reply=Rebuild::reply($rebuildOrder,['sender_email'=>$order['email'],'gmail_message_id'=>'abcdef123456','text'=>'All eighteen people are direct reports.']);
check($reply['message_id']==='abcdef123456','candidate reply provenance is retained');
check(Rebuild::nextRound(['round'=>0,'status'=>'delivered'])===1,'first revision is included');
check(Rebuild::nextRound(['round'=>1,'status'=>'delivered'])===2,'second revision is included');
rejects(fn()=>Rebuild::nextRound(['round'=>2,'status'=>'delivered']),'included_revisions_exhausted');
rejects(fn()=>Rebuild::nextRound(['round'=>0,'status'=>'processing']),'delivery_in_progress');
echo "All rebuild policy checks passed.\n";

foreach (['CvFulfilmentStore','CvFulfilmentOrders','CvRebuildMailer','CvRebuildService'] as $class) { require_once __DIR__.'/../app/Services/Cv/Automation/'.$class.'.php'; }
class RebuildTestOrders extends \App\Services\Cv\Automation\CvFulfilmentOrders {
    public array $fixture; public bool $existing=false;
    public function source(array $order): array { $text=$this->fixture['bundle']['source_text']; return ['sha256'=>hash('sha256',$text),'text'=>$text,'base64'=>base64_encode($text),'filename'=>'fixture.txt']; }
    public function hasExistingRebuild(array $order): bool { return $this->existing; }
    public function duplicateReference(array $order): ?string { return null; }
    public function payment(array $order,array $proof): void {}
    public function event(array $order,string $event,array $data): void {}
}
class RebuildTestMailer extends \App\Services\Cv\Automation\CvRebuildMailer {
    public int $calls=0; public bool $fail=false;
    public int $externalReceipts=0;
    public function recordExternalAttempt(array $order,array $message): int { return 900; }
    public function recordExternalReceipt(int $eventId,string $gmailId): void { $this->externalReceipts++; }
    public function send(array $order,string $stageId,string $title,string $body,array $files=[]): array {
        $this->calls++; if ($this->fail) { throw new RuntimeException('Simulated SMTP timeout'); }
        return ['accepted'=>true,'stage_id'=>$stageId,'recipient'=>$order['email'],'attachments'=>[]];
    }
}
$fixture=json_decode(file_get_contents(__DIR__.'/fixtures/cv_automation_rebuild.json'),true,64,JSON_THROW_ON_ERROR);
$ro=array_replace($rebuildOrder,['key'=>'upgrade:93','name'=>$fixture['bundle']['candidate_name'],'phone'=>'0000000000','upgrade_id'=>93]);
$rs=new \App\Services\Cv\Automation\CvFulfilmentStore(sys_get_temp_dir().'/hn-rebuild-'.bin2hex(random_bytes(8)));
$rr=new RebuildTestOrders(); $rr->fixture=$fixture; $rm=new RebuildTestMailer();
$svc=new \App\Services\Cv\Automation\CvRebuildService($rs,$rr,$rm);
rejects(fn()=>$svc->dispatch($ro,['action'=>'intake']),'payment_unconfirmed');
$svc->dispatch($ro,['action'=>'confirm_owner','proof'=>['type'=>'owner_confirmed','reference'=>$ro['reference'],'amount'=>1799,'source'=>'chat:exact-owner-confirmation']]);
$intake=['action'=>'intake','source_sha256'=>$fixture['bundle']['source_sha256'],'questions'=>[['question'=>'Were the eighteen people direct or indirect reports?','why'=>'This makes the leadership scope clear and accurate.','source_quote'=>'Led a team of 18 people across two production sites.']]];
check($svc->dispatch($ro,$intake)['fulfilment']['status']==='awaiting_answers','paid rebuild sends focused intake');
$svc->dispatch($ro,$intake); check($rm->calls===1,'duplicate intake does not send twice');
$rs->locked(function() use($rs,$ro) { $s=$rs->read('order:'.$ro['key']); $s['intake_sent_at']=gmdate('c',time()-400000); $rs->write('order:'.$ro['key'],$s); });
$svc->dispatch($ro,['action'=>'pause','sender_email'=>$ro['email'],'gmail_message_id'=>'abcdef123451','text'=>'Pause please']);
check($svc->dispatch($ro,['action'=>'remind'])['status']==='not_due' && $rm->calls===1,'pause suppresses due reminders');
$svc->dispatch($ro,['action'=>'resume','sender_email'=>$ro['email'],'gmail_message_id'=>'abcdef123452','text'=>'Please resume']);
$svc->dispatch($ro,['action'=>'remind']); $svc->dispatch($ro,['action'=>'remind']);
check($svc->dispatch($ro,['action'=>'remind'])['status']==='not_due' && $rm->calls===3,'only two due reminders can be sent');
$answer=['action'=>'answers','sender_email'=>$ro['email'],'gmail_message_id'=>'abcdef123456','text'=>$fixture['answers'],'templates'=>['ats_classic','executive_ats']];
$s=$svc->dispatch($ro,$answer); $again=$svc->dispatch($ro,$answer);
check(count($again['fulfilment']['answers'])===1 && $s['fulfilment']['answers_sha256']===$fixture['bundle']['answers_sha256'],'replayed candidate reply retains one evidence record');
$rr->existing=true; rejects(fn()=>$svc->dispatch($ro,['action'=>'claim']),'existing_delivery_owner'); $rr->existing=false;
$s=$svc->dispatch($ro,['action'=>'claim']); check(isset($s['lease']),'answered rebuild receives a lease');
rejects(fn()=>$svc->dispatch($ro,['action'=>'claim']),'already_processing');
$ro2=array_replace($ro,['key'=>'upgrade:94','reference'=>'UPI987654321']); $rm2=new RebuildTestMailer(); $rm2->fail=true;
$svc2=new \App\Services\Cv\Automation\CvRebuildService($rs,$rr,$rm2);
$svc2->dispatch($ro2,['action'=>'confirm_owner','proof'=>['type'=>'owner_confirmed','reference'=>$ro2['reference'],'amount'=>1799,'source'=>'chat:exact-owner-confirmation']]);
rejects(fn()=>$svc2->dispatch($ro2,$intake),'delivery_reconciliation_required');
rejects(fn()=>$svc2->dispatch($ro2,$intake),'delivery_reconciliation_required');
check($rm2->calls===1,'uncertain intake never blindly resends');
foreach ([0,1] as $round) {
    $state=$rs->read('order:'.$ro['key']); $state['status']='delivered'; $state['round']=$round; $rs->write('order:'.$ro['key'],$state);
    $r=$svc->dispatch($ro,['action'=>'request_revision','sender_email'=>$ro['email'],'gmail_message_id'=>'abcdef12346'.$round,'text'=>'Please shorten the professional summary.']);
    check($r['fulfilment']['round']===$round+1 && $r['fulfilment']['status']==='ready','revision preserves order and opens the next included round');
}
$state=$rs->read('order:'.$ro['key']); $state['status']='delivered'; $rs->write('order:'.$ro['key'],$state);
rejects(fn()=>$svc->dispatch($ro,['action'=>'request_revision','sender_email'=>$ro['email'],'gmail_message_id'=>'abcdef123469','text'=>'One more revision please.']),'included_revisions_exhausted');
echo "All rebuild state and delivery behaviour checks passed.\n";
require_once __DIR__.'/../app/Services/HiredNextEmail.php';
$ro3=array_replace($ro,['key'=>'upgrade:95','reference'=>'UPI192837465']);
$rm3=new RebuildTestMailer(); $svc3=new \App\Services\Cv\Automation\CvRebuildService($rs,$rr,$rm3);
$svc3->dispatch($ro3,['action'=>'confirm_owner','proof'=>['type'=>'owner_confirmed','reference'=>$ro3['reference'],'amount'=>1799,'source'=>'chat:exact-owner-confirmation']]);
$prepared=$svc3->dispatch($ro3,$intake+['transport'=>'gmail']);
check($prepared['fulfilment']['status']==='delivery_uncertain' && $rm3->calls===0 && $prepared['outbound']['to']===$ro3['email'],'native Gmail reservation does not also send SMTP');
check(str_contains($prepared['outbound']['html'],'font-size:16px') && str_contains($prepared['outbound']['html'],'#ff4e16'),'native message uses shared HiredNext typography');
rejects(fn()=>$svc3->dispatch($ro3,$intake+['transport'=>'gmail']),'delivery_reconciliation_required');
$receipt=$svc3->dispatch($ro3,['action'=>'reconcile','stage_id'=>$prepared['outbound']['stage_id'],'recipient'=>$ro3['email'],'gmail_message_id'=>'abcdef123499']);
check($receipt['fulfilment']['status']==='awaiting_answers' && $rm3->externalReceipts===1,'genuine native receipt completes the reserved stage');
$svc3->dispatch($ro3,$intake+['transport'=>'gmail']);
check($rm3->calls===0 && $rm3->externalReceipts===1,'completed native intake cannot send again');
echo "All native Gmail ownership checks passed.\n";
