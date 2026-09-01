<?php

namespace App\Services\Revenue;

class SlackSignatureVerifier
{
    public function verify(string $timestamp, string $signature, string $body, string $signingSecret, ?int $now = null): bool
    {
        if ($timestamp === '' || $signature === '' || $signingSecret === '') {
            return false;
        }
        if (!ctype_digit($timestamp)) {
            return false;
        }
        $now ??= time();
        if (abs($now - (int) $timestamp) > 300) {
            return false;
        }
        $base = 'v0:' . $timestamp . ':' . $body;
        $expected = 'v0=' . hash_hmac('sha256', $base, $signingSecret);
        return hash_equals($expected, $signature);
    }
}
