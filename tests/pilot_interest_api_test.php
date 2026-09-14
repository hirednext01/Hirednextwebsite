<?php
namespace App\Controllers\Api {class BaseApiController {public $request;public $response;}}
namespace Config {class Database {public static function connect(){return $GLOBALS['db'];}} class Services {public static function email(){return $GLOBALS['mail'];}}}
namespace {
require __DIR__.'/pilot_interest_capture_test.php';
require __DIR__.'/../app/Controllers/Api/ContactApi.php';
class ApiRequest extends FakeRequest {public function isAJAX(){return true;} public function getJSON($arg){throw new \RuntimeException('Form body must not be parsed as JSON');}}
class ApiResponse {public $code; public function setStatusCode($code){$this->code=$code;return $this;} public function setJSON($result){return $result;}}
$GLOBALS['db']=new FakeDb();$GLOBALS['mail']=new FakeMailer();
$c=new \App\Controllers\Api\ContactApi();$c->request=new ApiRequest($base+['subject'=>\App\Services\Revenue\PilotInterestService::SUBJECT]);$c->response=new ApiResponse();
$r=$c->submit();
check($r['receipt']==='HN-INTEREST-42'&&$c->response->code===200&&$GLOBALS['mail']->sends===1,'production API accepts the form body and executes pilot capture before generic JSON parsing');
}
