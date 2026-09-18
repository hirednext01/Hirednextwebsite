<?php

function mustContain(string $haystack, string $needle, string $label): void
{
    if (strpos($haystack, $needle) === false) {
        fwrite(STDERR, "FAIL: {$label}\n");
        exit(1);
    }
}

$root = dirname(__DIR__);
$routes = file_get_contents($root . '/app/Config/Routes.php');
$controller = file_get_contents($root . '/app/Controllers/CandidateServices.php');
$hub = file_get_contents($root . '/app/Views/pages/services/candidate-services.php');
$offers = file_get_contents($root . '/app/Views/pages/services/_candidate-offers.php');
$product = file_get_contents($root . '/app/Views/pages/services/cv-service-product.php');
$seo = file_get_contents($root . '/app/Controllers/Seo.php');

mustContain($routes, "services/professional-cv-rebuild", 'professional CV rebuild route');
mustContain($routes, "services/ats-cv-optimisation", 'ATS optimisation route');
mustContain($routes, "services/interview-coaching", 'interview coaching route');

mustContain($controller, "Professional CV Rebuild & CV Making Service in India", 'rebuild SEO title');
mustContain($controller, "ATS CV Optimisation Service in India", 'ATS SEO title');
mustContain($controller, "Interview Coaching & Interview Preparation in India", 'interview SEO title');
mustContain($controller, "Executive CV Writing Service in India for CXO & Senior Leaders", 'executive CV title owns high-intent search');
mustContain($controller, "'@type' => 'Service'", 'product pages must emit Service schema');

mustContain($hub, 'All live HiredNext career services', 'hub must expose complete live product catalogue');
mustContain($offers, 'ATS CV Optimisation', 'ATS must be visible in primary offer architecture');
mustContain($offers, '1:1 Interview Coaching with Taru', 'interview coaching must be visible in primary offer architecture');
mustContain($offers, 'Executive CV & Leadership Case Study', 'executive CV must remain prominent');
mustContain($product, 'Choose the service that matches the problem', 'product page cross-sell ladder');
mustContain($product, 'Paid career services are optional and separate from recruitment', 'service/recruitment separation');

mustContain($seo, "services/professional-cv-rebuild", 'rebuild page in discovery');
mustContain($seo, "services/ats-cv-optimisation", 'ATS page in discovery');
mustContain($seo, "services/interview-coaching", 'interview page in discovery');

echo "PASS career services product engine\n";
