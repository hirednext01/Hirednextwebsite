<?php
declare(strict_types=1);

function check(bool $ok, string $label): void { if (!$ok) { throw new RuntimeException('FAIL: ' . $label); } echo 'PASS: ' . $label . "\n"; }
function rejects(callable $call, string $message): void { try { $call(); } catch (DomainException $e) { check($e->getMessage() === $message, $message); return; } throw new RuntimeException('FAIL: expected ' . $message); }
$path = __DIR__ . '/../app/Services/Cv/Automation/CvFulfilmentPolicy.php';
check(is_file($path), 'automatic fulfilment policy exists');
require $path;
require __DIR__ . '/../app/Services/Cv/Automation/CvFulfilmentAccess.php';
use App\Services\Cv\Automation\CvFulfilmentPolicy as Policy;
use App\Services\Cv\Automation\CvFulfilmentAccess as Access;

$order = ['key'=>'assessment:81','lead_id'=>81,'service'=>'priority_599','email'=>'candidate@example.test','amount'=>599,'reference'=>'UPI123456789','payment_status'=>'pending_verification','is_test'=>false];
$token=Access::sign($order, str_repeat('k',32),1700001000);
check(Access::valid($order,$token,str_repeat('k',32),1700000900), 'valid capability is scoped to its order');
check(!Access::valid(array_replace($order,['key'=>'assessment:82']),$token,str_repeat('k',32),1700000900), 'capability cannot cross orders');
check(!Access::valid($order,$token,str_repeat('k',32),1700001001), 'expired capability fails');
check(!Access::valid(array_replace($order,['reference'=>'OTHER1234']),$token,str_repeat('k',32),1700000900), 'changed reference invalidates capability');
rejects(fn()=>Policy::payment($order,['type'=>'candidate_reference','reference'=>$order['reference'],'amount'=>599,'source'=>'email:123'],null), 'owner_confirmation_required');
rejects(fn()=>Policy::payment($order,['type'=>'owner_confirmed','reference'=>$order['reference'],'amount'=>99,'source'=>'chat:confirmation'],null), 'amount_mismatch');
rejects(fn()=>Policy::payment($order,['type'=>'owner_confirmed','reference'=>$order['reference'],'amount'=>599,'source'=>'chat:confirmation'],'assessment:82'), 'reference_used_by_another_order');
$proof=Policy::payment($order,['type'=>'owner_confirmed','reference'=>$order['reference'],'amount'=>599,'source'=>'chat:confirmation'],null);
check($proof['status']==='owner_confirmed' && $proof['cash_received_inr']===599, 'owner confirmation is recorded without claiming bank verification');
rejects(fn()=>Policy::claim(['status'=>'awaiting_payment'],time()), 'payment_unconfirmed');
rejects(fn()=>Policy::claim(['status'=>'processing','lease_expires_at'=>time()+300],time()), 'already_processing');
check(Policy::claim(['status'=>'delivered'],time())==='already_delivered', 'completed order does not restart');
rejects(fn()=>Policy::claim(['status'=>'delivery_uncertain'],time()), 'delivery_reconciliation_required');

$source='Experienced operations manager. Led a team of 18 people. Improved on-time dispatch from 82% to 94% across two sites. Responsible for production scheduling and weekly reporting.';
$report=['candidate_name'=>'Synthetic Candidate','target_role'=>'Operations Head','delivery_id'=>'HN-CV-ASSESSMENT-81','source_sha256'=>hash('sha256',$source),'source_text'=>$source,'external_api_cost_inr'=>0,'quality'=>['facts_checked'=>true,'no_invented_claims'=>true,'layout_checked'=>true], 'pages'=>[
 ['title'=>'Positioning and first impression','sections'=>[['heading'=>'Role fit','text'=>'The CV shows operating responsibility and a measurable delivery improvement. Make the target role and scope clear in the first paragraph.']]],
 ['title'=>'Evidence and shortlist barriers','sections'=>[['heading'=>'Leadership scope','text'=>'Describe the reporting line and decision authority; the team size alone does not establish business ownership.']]],
 ['title'=>'Priority improvements','sections'=>[['heading'=>'Actions','text'=>'Place the dispatch improvement near the top and retain the actual baseline and end value. Add budget scope only when you can support it.']]],
], 'evidence'=>[['quote'=>'Led a team of 18 people.','finding'=>'Team scale is stated; clarify reporting line and decision authority.']]];
$pdf="%PDF-1.4\n" . str_repeat("1 0 obj << /Type /Page /Parent 3 0 R >> endobj\n",3) . "%%EOF\n";
$manifest=[$report['candidate_name'],$report['target_role'],$report['delivery_id'] ?? '',$report['source_sha256'],array_map(fn($p)=>[$p['title'],array_map(fn($s)=>[$s['heading'],$s['text']],$p['sections'])],$report['pages'])];
$digest=hash('sha256',json_encode($manifest,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR));
$pdf.='HN_REPORT_SHA256:'.$digest;
check(Policy::report($report,hash('sha256',$source),$source,$pdf)==='accepted', 'evidenced three-page zero-API-cost report is accepted');
rejects(fn()=>Policy::report(array_replace($report,['external_api_cost_inr'=>1]),hash('sha256',$source),$source,$pdf),'new_api_spend_forbidden');
rejects(fn()=>Policy::report($report,str_repeat('0',64),$source,$pdf),'source_changed');
$bad=$report; $bad['evidence'][0]['quote']='Managed 500 staff';
rejects(fn()=>Policy::report($bad,hash('sha256',$source),$source,$pdf),'unsupported_evidence');
rejects(fn()=>Policy::report($report,hash('sha256',$source),$source,"%PDF-1.4\n/Type /Page\n%%EOF"),'three_page_pdf_required');
rejects(fn()=>Policy::report($report,hash('sha256',$source),$source,str_replace($digest,str_repeat('0',64),$pdf)),'pdf_content_mismatch');
echo "All automatic fulfilment policy checks passed.\n";
