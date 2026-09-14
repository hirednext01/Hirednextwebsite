<?php
declare(strict_types=1);
use App\Services\Cv\Automation\CvRebuildPolicy as Rebuild;
require __DIR__.'/cv_rebuild_automation_test.php';
$bundle=json_decode(file_get_contents($argv[1]),true,64,JSON_THROW_ON_ERROR);
$fixture=json_decode(file_get_contents(__DIR__.'/fixtures/cv_automation_rebuild.json'),true,64,JSON_THROW_ON_ERROR);
$o=['name'=>$bundle['candidate_name'],'email'=>'jobs@hirednext.info','phone'=>'0000000000'];
$s=['round'=>0,'answers_sha256'=>$bundle['answers_sha256'],'current_delivery_id'=>$bundle['delivery_id'],'templates'=>['ats_classic','executive_ats'],'answers'=>[['text'=>$fixture['answers']]]];
$src=['sha256'=>$bundle['source_sha256'],'text'=>$fixture['bundle']['source_text']];
check(count(Rebuild::bundle($o,$s,$bundle,$src))===3,'actual locally rendered PDFs satisfy delivery policy');
$bad=$bundle; $bad['variants'][0]['content']['summary'].=' Managed 999 people.';
rejects(fn()=>Rebuild::bundle($o,$s,$bad,$src),'unsupported_numeric_claim');
$bad=$bundle; $bad['candidate_email']='wrong@example.test';
rejects(fn()=>Rebuild::bundle($o,$s,$bad,$src),'rebuild_context_changed');
$bad=$bundle; $bad['variants'][0]['pdf_base64']=$bundle['variants'][1]['pdf_base64'];
rejects(fn()=>Rebuild::bundle($o,$s,$bad,$src),'pdf_content_mismatch');
$bad=$bundle; $bad['answers_sha256']=str_repeat('0',64);
rejects(fn()=>Rebuild::bundle($o,$s,$bad,$src),'rebuild_context_changed');
echo "All rendered bundle checks passed.\n";
