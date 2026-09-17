<?php

require_once __DIR__ . '/../app/Services/RecruitOsIntakeClient.php';

use App\Services\RecruitOsIntakeClient;

function assertSameValue($expected, $actual, string $message): void
{
    if ($expected !== $actual) {
        fwrite(STDERR, $message . "\nExpected: " . var_export($expected, true) . "\nActual: " . var_export($actual, true) . "\n");
        exit(1);
    }
}

function assertThrows(callable $operation, string $message): void
{
    try {
        $operation();
    } catch (RuntimeException $e) {
        return;
    }
    fwrite(STDERR, $message . "\n");
    exit(1);
}

$temp = tempnam(sys_get_temp_dir(), 'hn-cv-');
file_put_contents($temp, "%PDF-1.4\nSynthetic CV");
$calls = [];
$transport = static function (string $method, string $url, array $options) use (&$calls): array {
    $calls[] = compact('method', 'url', 'options');
    if ($method === 'GET') {
        return ['status' => 200, 'body' => json_encode(['job_code' => 'JOB-1032', 'application_count' => 17])];
    }
    return ['status' => 200, 'body' => json_encode([
        'status' => 'stored',
        'receipt_id' => 'receipt-1',
        'candidate_id' => 'candidate-1',
        'document_id' => 'document-1',
        'application_id' => 'application-1',
        'requires_review' => false,
    ])];
};

$client = new RecruitOsIntakeClient('https://recruit.example/api/ingest/resumes', 'test-key', $transport);
$metadata = [
    'source' => 'job_portal',
    'source_account' => 'hirednext.net',
    'external_id' => 'website-source-1',
    'attachment_id' => 'sha256-source-1',
    'job_code' => 'JOB-1032',
    'candidate_name' => 'Asha Candidate',
    'candidate_email' => 'asha@example.test',
    'candidate_phone' => '+91 98765 43210',
    'candidate_linkedin' => 'https://www.linkedin.com/in/asha-candidate',
    'candidate_message' => 'Led a 12-person merchandising team.',
    'identity_verified' => true,
];

$receipt = $client->submit($temp, 'Asha_Candidate.pdf', 'application/pdf', $metadata);
assertSameValue('candidate-1', $receipt['candidate_id'], 'A durable candidate receipt must be returned.');
assertSameValue('POST', $calls[0]['method'], 'CV intake must use POST.');
assertSameValue('test-key', $calls[0]['options']['headers']['X-Api-Key'], 'The key must be sent only as a server-side header.');
assertSameValue($metadata, json_decode($calls[0]['options']['metadata'], true), 'Verified applicant fields must reach Recruit OS unchanged.');
assertSameValue($temp, $calls[0]['options']['file_path'], 'The temporary upload must be forwarded without moving it into website storage.');
assertSameValue(17, $client->applicationCount('JOB-1032'), 'The website must use the exact ATS application count.');

$badTransport = static fn (): array => ['status' => 200, 'body' => json_encode([
    'status' => 'stored', 'receipt_id' => 'r', 'candidate_id' => 'c', 'document_id' => 'd',
    'application_id' => null, 'requires_review' => true,
])];
$badClient = new RecruitOsIntakeClient('https://recruit.example/api/ingest/resumes', 'test-key', $badTransport);
assertThrows(
    static fn () => $badClient->submit($temp, 'Asha_Candidate.pdf', 'application/pdf', $metadata),
    'A mapped website job must not claim success without an ATS application ID.'
);

unlink($temp);
echo "Recruit OS direct intake contract passed.\n";
