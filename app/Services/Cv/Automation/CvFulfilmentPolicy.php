<?php
declare(strict_types=1);
namespace App\Services\Cv\Automation;

final class CvFulfilmentPolicy
{
    public static function reference(string $value): string
    {
        return strtoupper(preg_replace('/\s+/', '', trim($value)) ?? '');
    }

    public static function payment(array $order, array $proof, ?string $usedBy): array
    {
        $isTest = ($order['is_test'] ?? false) === true;
        $price=['priority_599'=>599,'rebuild_1799'=>1799][$order['service'] ?? ''] ?? null;
        if ($price===null || (int)$order['amount'] !== ($isTest ? 0 : $price)) { throw new \DomainException('existing_service_owner_required'); }
        $type = $isTest ? 'internal_test' : 'owner_confirmed';
        if (($proof['type'] ?? '') !== $type || strlen(trim((string)($proof['source'] ?? ''))) < 8) {
            throw new \DomainException('owner_confirmation_required');
        }
        if (!isset($proof['amount']) || !is_numeric($proof['amount']) || (float)$proof['amount'] !== (float)$order['amount']) {
            throw new \DomainException('amount_mismatch');
        }
        $reference = self::reference((string)($proof['reference'] ?? ''));
        if (strlen($reference) < 6 || $reference !== self::reference((string)$order['reference'])) {
            throw new \DomainException('reference_mismatch');
        }
        if ($usedBy !== null && $usedBy !== $order['key']) {
            throw new \DomainException('reference_used_by_another_order');
        }
        return ['status'=>$type, 'reference'=>$reference, 'cash_received_inr'=>$isTest ? 0 : (int)$order['amount'],
            'source'=>mb_substr(trim((string)$proof['source']),0,1500), 'confirmed_at'=>gmdate('c'),
            'external_api_cash_cost_inr'=>0, 'allocated_overhead_inr'=>null, 'net_profit_inr'=>null];
    }

    public static function claim(array $state, int $now): string
    {
        $status = $state['status'] ?? 'awaiting_payment';
        if ($status === 'delivered') { return 'already_delivered'; }
        if ($status === 'delivery_uncertain') { throw new \DomainException('delivery_reconciliation_required'); }
        if ($status === 'processing' && ($state['lease_expires_at'] ?? 0) > $now) { throw new \DomainException('already_processing'); }
        if (!in_array($status, ['ready','processing'], true)) { throw new \DomainException('payment_unconfirmed'); }
        return 'claim';
    }

    public static function report(array $report, string $sourceHash, string $sourceText, string $pdf): string
    {
        if (!hash_equals($sourceHash, (string)($report['source_sha256'] ?? ''))) { throw new \DomainException('source_changed'); }
        if (!isset($report['external_api_cost_inr']) || !is_numeric($report['external_api_cost_inr']) || (float)$report['external_api_cost_inr'] !== 0.0) { throw new \DomainException('new_api_spend_forbidden'); }
        foreach (['facts_checked','no_invented_claims','layout_checked'] as $gate) {
            if (($report['quality'][$gate] ?? false) !== true) { throw new \DomainException('quality_check_required'); }
        }
        if (!is_array($report['pages'] ?? null) || count($report['pages']) !== 3) { throw new \DomainException('three_report_pages_required'); }
        $narrative = '';
        foreach ($report['pages'] as $page) {
            if (!is_string($page['title'] ?? null) || trim($page['title']) === '' || !is_array($page['sections'] ?? null) || count($page['sections']) < 1) { throw new \DomainException('report_incomplete'); }
            foreach ($page['sections'] as $section) {
                if (!is_string($section['heading'] ?? null) || !is_string($section['text'] ?? null) || strlen(trim($section['text'])) < 35) { throw new \DomainException('report_incomplete'); }
                $narrative .= ' ' . $section['text'];
            }
        }
        if (strlen($narrative) > 20000 || preg_match('/guaranteed (?:interview|job|shortlist)|100% (?:shortlist|placement)|reviewed personally by Taru/i', $narrative)) { throw new \DomainException('unsupported_promise'); }
        if (!is_array($report['evidence'] ?? null) || count($report['evidence']) < 1) { throw new \DomainException('evidence_required'); }
        $sourceText = self::normaliseText($sourceText);
        if (strlen($sourceText) < 120) { throw new \DomainException('readable_source_required'); }
        foreach ($report['evidence'] as $evidence) {
            $quote = self::normaliseText((string)($evidence['quote'] ?? ''));
            if (strlen($quote) < 12 || !str_contains($sourceText,$quote) || strlen(trim((string)($evidence['finding'] ?? ''))) < 20) { throw new \DomainException('unsupported_evidence'); }
        }
        if (strlen($pdf) > 1500000 || !str_starts_with($pdf,'%PDF-') || !str_contains($pdf,'%%EOF') || preg_match_all('~/Type\s*/Page\b~',$pdf) !== 3) { throw new \DomainException('three_page_pdf_required'); }
        if (preg_match('~/(?:JavaScript|JS|Launch|EmbeddedFile)\b~',$pdf)) { throw new \DomainException('active_pdf_forbidden'); }
        $manifest=[$report['candidate_name'] ?? '',$report['target_role'] ?? '',$report['delivery_id'] ?? '',$report['source_sha256'],array_map(static fn($p)=>[$p['title'],array_map(static fn($s)=>[$s['heading'],$s['text']],$p['sections'])],$report['pages'])];
        $digest=hash('sha256',json_encode($manifest,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_THROW_ON_ERROR));
        if (!str_contains($pdf,'HN_REPORT_SHA256:'.$digest)) { throw new \DomainException('pdf_content_mismatch'); }
        return 'accepted';
    }

    private static function normaliseText(string $text): string
    {
        return trim(preg_replace('/\s+/u',' ',str_replace("\xC2\xA0",' ',$text)) ?? '');
    }
}
