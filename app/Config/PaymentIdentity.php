<?php

namespace Config;

/**
 * Single source of truth for every HiredNext customer payment destination.
 *
 * Service pages must never embed their own QR, UPI VPA or payment URL.
 * A destination stays disabled until its exact HTTPS merchant URL has been
 * independently verified to resolve to HiredNext Recruitment and the URL
 * fingerprint is committed here.
 */
final class PaymentIdentity
{
    public const DISPLAY_NAME = 'HiredNext Recruitment';
    public const PAYMENT_EMAIL = 'jobs@hirednext.info';
    public const CONFIRMATION_EMAIL = 'partners@hirednext.info';

    /**
     * Fail closed. Populate only after a live payer-app check confirms that
     * the destination displays HiredNext Recruitment.
     */
    private const APPROVED_DESTINATION_SHA256 = '';

    public static function destination(): array
    {
        $url = trim((string) env('HIREDNEXT_BUSINESS_PAYMENT_URL', ''));
        $declaredPayee = trim((string) env('HIREDNEXT_BUSINESS_PAYMENT_DISPLAY_NAME', ''));
        $approvedHash = self::APPROVED_DESTINATION_SHA256;

        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));
        $host = trim((string) parse_url($url, PHP_URL_HOST));

        // Hosted HTTPS merchant pages only. Raw UPI/VPA links and embedded
        // payment identifiers are never accepted as website destinations.
        $safeShape = $url !== ''
            && $scheme === 'https'
            && $host !== ''
            && !str_contains($url, '@')
            && stripos($url, 'upi:') === false;

        $correctPayee = $declaredPayee !== ''
            && hash_equals(self::DISPLAY_NAME, $declaredPayee);

        $fingerprintMatches = $approvedHash !== ''
            && hash_equals($approvedHash, hash('sha256', $url));

        $active = $safeShape && $correctPayee && $fingerprintMatches;

        return [
            'active' => $active,
            'display_name' => self::DISPLAY_NAME,
            'url' => $active ? $url : '',
            'payment_email' => self::PAYMENT_EMAIL,
            'confirmation_email' => self::CONFIRMATION_EMAIL,
            'temporary_qr_active' => true,
        ];
    }
}
