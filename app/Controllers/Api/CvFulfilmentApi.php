<?php
declare(strict_types=1);
namespace App\Controllers\Api;

use App\Services\Cv\Automation\CvFulfilmentService;

class CvFulfilmentApi extends \App\Controllers\BaseController
{
    public function handle()
    {
        $this->response->setHeader('Cache-Control','private, no-store')->setHeader('X-Robots-Tag','noindex, nofollow');
        $body=$this->request->getBody();
        if (strlen($body)>6000000) { return $this->response->setStatusCode(413)->setJSON(['ok'=>false,'error'=>'request_too_large']); }
        try {
            $data=json_decode($body,true,32,JSON_THROW_ON_ERROR);
            if (!is_array($data) || !preg_match('/^(assessment|upgrade):[1-9][0-9]{0,9}$/',(string)($data['order_key'] ?? '')) || !preg_match('/^[0-9]{10}\.[a-f0-9]{64}$/',(string)($data['access'] ?? ''))) { throw new \DomainException('access_denied'); }
            return $this->response->setJSON(['ok'=>true,'result'=>(new CvFulfilmentService())->dispatch($data)]);
        } catch (\JsonException $e) {
            return $this->response->setStatusCode(400)->setJSON(['ok'=>false,'error'=>'invalid_json']);
        } catch (\DomainException $e) {
            $status=$e->getMessage()==='access_denied'?401:409;
            return $this->response->setStatusCode($status)->setJSON(['ok'=>false,'error'=>$e->getMessage()]);
        } catch (\Throwable $e) {
            log_message('error','CV fulfilment infrastructure exception: '.get_class($e));
            return $this->response->setStatusCode(503)->setJSON(['ok'=>false,'error'=>'fulfilment_connection_unavailable']);
        }
    }
}
