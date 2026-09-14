<?php
declare(strict_types=1);
namespace App\Models {
    class CvEmailEventModel {
        public function recordAttempt(...$args) { return 1; }
        public function markSent(...$args): void {}
        public function markFailed(...$args): void {}
    }
}
namespace Config {
    class Services {
        public static $email;
        public static function email() { return self::$email; }
    }
}
namespace {
    require __DIR__.'/../system/Email/Email.php';
    require __DIR__.'/../app/Services/HiredNextEmail.php';
    require __DIR__.'/../app/Services/Cv/Automation/CvFulfilmentMailer.php';
    class AttachmentCaptureEmail extends \CodeIgniter\Email\Email {
        public function __construct($config=null) { $this->validate=false; }
        protected function setDate() { return 'Mon, 14 Sep 2026 09:00:00 +0000'; }
        public function send($autoClear=true) { return true; }
        public function attachmentBytes(): string { return base64_decode($this->attachments[0]['content'],true); }
    }
    $email=new AttachmentCaptureEmail(); \Config\Services::$email=$email;
    $path=tempnam(sys_get_temp_dir(),'hn-pdf-');
    $pdf="%PDF-1.4\n".str_repeat('Synthetic assessment content. ',100)."\n%%EOF\n";
    file_put_contents($path,$pdf);
    (new \App\Services\Cv\Automation\CvFulfilmentMailer())->deliver(['lead_id'=>1,'email'=>'jobs@hirednext.info','name'=>'Internal Test','is_test'=>true],$path,'HN-CV-ASSESSMENT-TEST');
    unlink($path);
    if ($email->attachmentBytes()!==$pdf) { fwrite(STDERR,"FAIL: attachment must contain exact PDF bytes, not the private storage path.\n"); exit(1); }
    echo "PASS: actual CodeIgniter attachment contains the complete original PDF bytes.\n";
}
