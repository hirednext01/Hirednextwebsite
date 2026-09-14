<?php
function log_message(...$args) {}
require __DIR__ . '/../app/Services/HiredNextEmail.php';
require __DIR__ . '/../app/Services/Revenue/PilotInterestService.php';
class FakeRequest {
    public array $data;
    public function __construct(array $data) {$this->data=$data;}
    public function getPost($key) {return $this->data[$key]??null;}
    public function getIPAddress(){return '192.0.2.10';}
}
class FakeDb {
    public bool $save=true; public ?array $existing=null; public int $recent=0; public array $inserted=[];
    public function table($name){return $this;}
    public function where(...$args){return $this;}
    public function orderBy(...$args){return $this;}
    public function get(){return $this;}
    public function getRowArray(){return $this->existing;}
    public function countAllResults(){return $this->recent;}
    public function insert($data){$this->inserted=$data;return $this->save;}
    public function insertID(){return 42;}
}
class FakeMailer {
    public int $sends=0; public bool $success=true; public array $values=[];
    public function __call($name,$args){$this->values[$name]=$args;return $this;}
    public function send($debug){$this->sends++;return $this->success;}
}
function check($ok,$message){if(!$ok){throw new RuntimeException('FAIL: '.$message);}echo "PASS: $message\n";}
$base=['name'=>'Example Candidate','email'=>'candidate@example.com','message'=>'Operations Manager interview next week','consent'=>'interview_pilot_updates_only'];
$s=new \App\Services\Revenue\PilotInterestService();
$db=new FakeDb();$mail=new FakeMailer();$r=$s->capture(new FakeRequest($base),$db,$mail);
check($r['receipt']==='HN-INTEREST-42'&&$r['email_status']==='sent','persisted receipt and SMTP success are reported');
check($mail->sends===1&&$mail->values['setTo'][0]==='candidate@example.com'&&$mail->values['setBCC'][0]==='jobs@hirednext.info','acknowledgement goes to candidate with jobs workflow copy');
check(str_contains($mail->values['setMessage'][0],'No payment has been taken')&&!str_contains($mail->values['setMessage'][0],'payment verified'),'interest is never called payment verification');
$db=new FakeDb();$db->save=false;$mail=new FakeMailer();$r=$s->capture(new FakeRequest($base),$db,$mail);
check($r['status']==='error'&&$mail->sends===0,'failed persistence never sends or reports success');
$bad=$base;unset($bad['consent']);$db=new FakeDb();$mail=new FakeMailer();$r=$s->capture(new FakeRequest($bad),$db,$mail);
check($r['status']==='error'&&$mail->sends===0&&!$db->inserted,'missing consent never saves or sends');
$bad=$base;$bad['company_website']='spam';$r=$s->capture(new FakeRequest($bad),new FakeDb(),new FakeMailer());
check($r['status']==='error','honeypot blocks automated spam submissions');
$db=new FakeDb();$db->existing=['id'=>41];$mail=new FakeMailer();$r=$s->capture(new FakeRequest($base),$db,$mail);
check($r['receipt']==='HN-INTEREST-41'&&$r['duplicate']&&$mail->sends===0,'repeated identical submission reuses receipt without resending');
$db=new FakeDb();$db->recent=5;$mail=new FakeMailer();$r=$s->capture(new FakeRequest($base),$db,$mail);
check($r['status']==='error'&&$mail->sends===0,'rate limit prevents another email');
$db=new FakeDb();$mail=new FakeMailer();$mail->success=false;$r=$s->capture(new FakeRequest($base),$db,$mail);
check($r['status']==='success'&&$r['email_status']==='unconfirmed','SMTP failure preserves the lead without claiming email delivery');
