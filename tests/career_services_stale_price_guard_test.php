<?php
$root = dirname(__DIR__);

$paths = [
    $root . '/app/Views/pages',
    $root . '/app/Views/components',
    $root . '/app/Views/layouts',
    $root . '/app/Controllers/CandidateServices.php',
    $root . '/app/Controllers/DecisionGuides.php',
    $root . '/app/Controllers/Seo.php',
    $root . '/app/Config/DecisionGuides.php',
    $root . '/app/Config/CareerAuthority.php',
];

$patterns = [
    '/₹\\s*599\\b/u' => 'stale ₹599 public price',
    '/₹\\s*1,?799\\b/u' => 'stale ₹1,799 public price',
    '/₹\\s*5,?500\\b/u' => 'stale ₹5,500 public LinkedIn price',
    '/₹\\s*5,?999\\b/u' => 'stale ₹5,999 public LinkedIn price',
    '/priority_599/' => 'legacy priority_599 exposed outside compatibility service',
    '/rebuild_1799/' => 'legacy rebuild_1799 exposed outside compatibility service',
    '/linkedin_5500/' => 'legacy linkedin_5500 tier exposed outside compatibility service',
    '/linkedin_5999/' => 'legacy linkedin_5999 tier exposed outside compatibility service',
];

$failures = [];

$scan = function (string $file) use (&$failures, $patterns): void {
    if (!is_file($file)) return;
    $normalized = str_replace(chr(92), '/', $file);
    if (str_contains($normalized, '/app/Views/pages/admin/')) return;
    if (str_ends_with($normalized, '/app/Views/pages/services/linkedin-leadership-payment.php')) return; // private noindex named-client checkout; public price remains ₹8,999 + GST
    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
    if (!in_array($ext, ['php', 'js', 'mjs', 'html'], true)) return;
    $content = file_get_contents($file);
    foreach ($patterns as $pattern => $label) {
        if (preg_match($pattern, $content)) {
            $failures[] = $label . ' in ' . $file;
        }
    }
};

foreach ($paths as $path) {
    if (is_file($path)) {
        $scan($path);
        continue;
    }
    if (!is_dir($path)) continue;
    $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
    foreach ($it as $file) {
        if ($file->isFile()) $scan($file->getPathname());
    }
}

if ($failures) {
    fwrite(STDERR, "FAIL: stale career-service pricing found\n - " . implode("\n - ", $failures) . "\n");
    exit(1);
}

echo "PASS: no retired ₹599 / ₹1,799 / ₹5,500 / ₹5,999 career-service pricing is publicly exposed\n";
