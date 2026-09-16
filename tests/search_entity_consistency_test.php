<?php
$root = dirname(__DIR__);
$failures = [];
$require = static function (bool $condition, string $message) use (&$failures): void {
    if (!$condition) $failures[] = $message;
};

$robots = @file_get_contents($root . '/public/robots.txt') ?: '';
$landing = @file_get_contents($root . '/public/recruitment-agency-india/index.html') ?: '';
$sitemap = @file_get_contents($root . '/public/sitemap-search.xml') ?: '';
$brand = @file_get_contents($root . '/app/Config/BrandFacts.php') ?: '';
$entity = @file_get_contents($root . '/app/Controllers/EntityAuthority.php') ?: '';

$require(str_contains($robots, 'Disallow: /api/'), 'robots must block /api/');
$require(str_contains($robots, 'Disallow: /admin/'), 'robots must block /admin/');
$require(str_contains($robots, 'Sitemap: https://hirednext.net/sitemap-search.xml'), 'robots must advertise search sitemap');
$require(str_contains($landing, '<title>Recruitment Agency India | Executive Search & Leadership Hiring | HiredNext</title>'), 'landing page must target broad India recruitment intent');
$require(str_contains($landing, 'no public walk-in office'), 'landing page must state no public walk-in office');
$require(str_contains($landing, 'application/ld+json'), 'landing page must include JSON-LD');
$require(str_contains($sitemap, 'https://hirednext.net/recruitment-agency-india/'), 'search sitemap must include recruitment landing page');
$require(str_contains($brand, "'founded_in' => 'India'"), 'brand facts must not claim a conflicting founding city');
$require(str_contains($brand, "'operating_base' => 'Gurugram (Gurgaon), Delhi NCR, India'"), 'brand facts must normalize Gurugram/Gurgaon');
$require(str_contains($brand, 'no public walk-in office'), 'brand facts must describe remote-first/no walk-in delivery');
$require(str_contains($entity, "'name' => 'India'"), 'entity authority must identify India as founding location');
$require(!str_contains($entity, "'name' => 'Mumbai, India'"), 'entity authority must not publish conflicting Mumbai founding location');
$require(!str_contains($entity, 'streetAddress'), 'entity authority must not invent a storefront address');

if ($failures) {
    fwrite(STDERR, "FAIL\n - " . implode("\n - ", $failures) . "\n");
    exit(1);
}

echo "PASS search/entity consistency\n";
