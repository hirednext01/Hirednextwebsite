<?php
declare(strict_types=1);
namespace App\Services\Cv\Automation;

final class CvFulfilmentAccess
{
    public static function issue(array $order): string
    {
        return self::sign($order,(new CvFulfilmentStore())->secret(),time()+14*86400);
    }
    public static function sign(array $order,string $key,int $expires): string
    {
        $binding=json_encode([$order['key'],strtolower($order['email']),(int)$order['amount'],CvFulfilmentPolicy::reference($order['reference']),$expires],JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR);
        return $expires.'.'.hash_hmac('sha256',$binding,$key);
    }
    public static function valid(array $order,string $token,string $key,int $now): bool
    {
        if (!preg_match('/^([0-9]{10})\.([a-f0-9]{64})$/',$token,$match)) { return false; }
        $expires=(int)$match[1];
        return $expires >= $now && $expires <= $now+14*86400 && hash_equals(self::sign($order,$key,$expires),$token);
    }
    public static function notice(array $order): string
    {
        return "\nINTERNAL AUTOMATION HANDOFF — DO NOT FORWARD\nAutomation order: ".$order['key']."\nAutomation access: ".self::issue($order)."\nEndpoint: https://hirednext.net/api/cv-fulfilment\nThis access is private and expires in fourteen days. It does not establish payment receipt.\n";
    }
    public static function noticeForKey(string $key): string
    {
        try { return self::notice((new CvFulfilmentOrders())->load($key)); }
        catch (\Throwable $e) {
            // A bridge issue must not break the established payment capture or
            // customer acknowledgement. The internal owner receives the exception.
            log_message('error','CV automation handoff unavailable for '.$key);
            return "\nAutomation handoff unavailable for ".$key.". Payment remains unverified; retain this alert for the existing service owner.\n";
        }
    }
}
