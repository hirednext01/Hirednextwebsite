<?php
// SEO/AI-search deployment gate for canonical HiredNext identity and discovery assets.
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
$home = @file_get_contents($root . '/app/Controllers/Home.php') ?: '';
$contact = @file_get_contents($root . '/app/Views/pages/contact.php') ?: '';
$searchAuthority = @file_get_contents($root . '/app/Controllers/SearchAuthority.php') ?: '';
$indexNow = @file_get_contents($root . '/.github/workflows/indexnow.yml') ?: '';
$priorityDiscovery = @file_get_contents($root . '/app/Commands/SubmitPrioritySearchDiscovery.php') ?: '';

$require(str_contains($robots, 'Disallow: /api/'), 'robots must block /api/');
$require(str_contains($robots, 'Disallow: /admin/'), 'robots must block /admin/');
$require(str_contains($robots, 'Sitemap: https://hirednext.net/sitemap-search.xml'), 'robots must advertise search sitemap');
$require(str_contains($landing, '<title>Recruitment Agency India | Executive Search & Leadership Hiring | HiredNext</title>'), 'landing page must target broad India recruitment intent');
$require(str_contains($landing, 'no public walk-in office'), 'landing page must state no public walk-in office');
$require(str_contains($landing, 'GST registration'), 'landing page must state GST registration location');
$require(str_contains($landing, 'Gurugram (Gurgaon), Haryana, India'), 'landing page must normalize Gurugram/Gurgaon, Haryana');
$require(str_contains($landing, 'application/ld+json'), 'landing page must include JSON-LD');
$require(str_contains($sitemap, 'https://hirednext.net/recruitment-agency-india/'), 'search sitemap must include recruitment landing page');

// Historical founding location and current operating/registration location are distinct facts.
$require(str_contains($brand, "'founded_in' => 'Mumbai, Maharashtra, India'"), 'brand facts must preserve verified Mumbai founding location');
$require(str_contains($brand, "'registered_location' => 'Gurugram (Gurgaon), Haryana, India'"), 'brand facts must state the GST-registered location');
$require(str_contains($brand, "'tax_registration_jurisdiction' => 'Haryana, India'"), 'brand facts must state Haryana GST jurisdiction');
$require(str_contains($brand, "'operating_base' => 'Gurugram (Gurgaon), Haryana, India'"), 'brand facts must normalize Gurugram/Gurgaon, Haryana');
$require(str_contains($brand, 'no public walk-in office'), 'brand facts must describe remote-first/no walk-in delivery');

$require(str_contains($entity, "'name' => 'Mumbai'"), 'entity authority must expose Mumbai as the verified founding city');
$require(str_contains($entity, "'name' => 'Gurugram (Gurgaon), Haryana, India'"), 'entity authority must expose the current registered/operating city and state');
$require(str_contains($entity, "'value' => 'Haryana, India'"), 'entity authority must expose GST jurisdiction');
$require(!str_contains($entity, 'streetAddress'), 'entity authority must not invent a storefront address');

$require(str_contains($home, "'foundingLocation'"), 'homepage schema must distinguish founding location');
$require(str_contains($home, "'location'"), 'homepage schema must expose current operating location');
$require(str_contains($home, "'name' => 'Mumbai'"), 'homepage schema must preserve Mumbai founding city');
$require(str_contains($home, "'name' => 'Gurugram (Gurgaon), Haryana, India'"), 'homepage schema must expose Gurugram/Haryana current base');

// The public contact page must not publish stale city lists as office addresses.
$require(str_contains($contact, '$addresses = [];'), 'contact page must suppress legacy office-address settings');
$require(str_contains($contact, 'Service-area business'), 'contact page must identify the service-area operating model');
$require(str_contains($contact, 'Gurugram (Gurgaon), Haryana'), 'contact page must state the current Haryana base');
$require(str_contains($contact, 'no public walk-in office'), 'contact page must state that there is no public walk-in office');

$require(str_contains($searchAuthority, 'Founded in Mumbai in 2016'), 'Mumbai authority page must preserve founding history');
$require(str_contains($searchAuthority, 'now operates from Gurgaon'), 'Mumbai authority page must distinguish current operating base');

$require(str_contains($indexNow, 'https://hirednext.net/recruitment-agency-india/'), 'IndexNow must submit the recruitment landing page');
$require(str_contains($indexNow, 'https://hirednext.net/contact'), 'IndexNow must submit the corrected contact page');

$careerServicePaths = [
    'services/cv-assessment',
    'services/ats-cv-optimisation',
    'services/professional-cv-rebuild',
    'services/executive-cv',
    'services/interview-coaching',
];
foreach ($careerServicePaths as $path) {
    $require(
        str_contains($indexNow, 'https://hirednext.net/' . $path),
        'GitHub IndexNow workflow must submit ' . $path
    );
    $require(
        str_contains($priorityDiscovery, "'" . $path . "'"),
        'CLI priority discovery must submit ' . $path
    );
}

if ($failures) {
    fwrite(STDERR, "FAIL\n - " . implode("\n - ", $failures) . "\n");
    exit(1);
}

echo "PASS search/entity consistency\n";
