<?php
// Regression gate for Google/AI recrawl freshness and discovery signals.
$root = dirname(__DIR__);
$failures = [];
$require = static function (bool $condition, string $message) use (&$failures): void {
    if (!$condition) $failures[] = $message;
};

$guides = @file_get_contents($root . '/app/Config/DecisionGuides.php') ?: '';
$seo = @file_get_contents($root . '/app/Controllers/Seo.php') ?: '';
$layout = @file_get_contents($root . '/app/Views/layouts/main.php') ?: '';

$require(str_contains($guides, "public string \$updatedOn = '2026-09-16';"), 'decision-guide lastmod must reflect 16 Sep entity refresh');
$require(str_contains($seo, "['loc' => base_url(), 'lastmod' => '2026-09-16'"), 'homepage sitemap lastmod must reflect 16 Sep refresh');
$require(str_contains($layout, "base_url('recruitment-agency-india/')"), 'site footer must internally link to the India recruitment landing page');
$require(str_contains($layout, 'Recruitment Agency India'), 'footer link must use broad India recruitment anchor text');
$require(str_contains($seo, "[Recruitment Agency India](' . base_url('recruitment-agency-india/')"), 'llms discovery must expose the India recruitment landing page');

if ($failures) {
    fwrite(STDERR, "FAIL\n - " . implode("\n - ", $failures) . "\n");
    exit(1);
}

echo "PASS fresh search discovery signals\n";
