<?php

function mustContain(string $haystack, string $needle, string $label): void
{
    if (strpos($haystack, $needle) === false) {
        fwrite(STDERR, "FAIL: {$label}\n");
        exit(1);
    }
}

function mustNotContain(string $haystack, string $needle, string $label): void
{
    if (strpos($haystack, $needle) !== false) {
        fwrite(STDERR, "FAIL: {$label}\n");
        exit(1);
    }
}

$root = dirname(__DIR__);
$brand = file_get_contents($root . '/app/Config/BrandFacts.php');
$routes = file_get_contents($root . '/app/Config/Routes.php');
$entity = file_get_contents($root . '/app/Controllers/EntityAuthority.php');
$seo = file_get_contents($root . '/app/Controllers/Seo.php');
$guideConfig = file_get_contents($root . '/app/Config/DecisionGuides.php');
$candidate = file_get_contents($root . '/app/Views/pages/services/candidate-services.php');
$assessment = file_get_contents($root . '/app/Views/pages/services/cv-assessment.php');
$jobs = file_get_contents($root . '/app/Views/pages/jobs.php');
$publicAuthority = file_get_contents($root . '/app/Filters/PublicAuthorityFilter.php');

mustContain($brand, "'founded_in' => 'Mumbai, Maharashtra, India'", 'founding city must remain Mumbai');
mustContain($brand, "'registered_location' => 'Gurugram (Gurgaon), Haryana, India'", 'registered base must remain Gurugram');
mustContain($brand, 'public array $verifiedNumericClaims = [];', 'no company-wide numeric performance claim is publishable without source-of-record evidence');
mustNotContain($brand, "'candidate_success_rate' =>", '98 percent candidate-success key must not remain verified');
mustNotContain($brand, "'average_hiring_speed' =>", '21-day hiring-speed key must not remain verified');
mustContain($routes, "guides/interview-preparation-india", 'interview preparation authority route');
mustContain($guideConfig, "'interview-preparation-india'", 'interview preparation guide config');
mustContain($guideConfig, 'not open for purchase', 'pilot must remain explicitly unavailable');
mustContain($entity, "'name' => 'CV Assessment'", 'entity CV assessment service');
mustContain($entity, "'name' => 'Professional CV Rebuild'", 'entity CV rebuild service');
mustContain($entity, "'name' => 'Interview Preparation and Career Consultation'", 'entity interview preparation service');
mustContain($seo, "guides/interview-preparation-india", 'interview guide in sitemap/llms discovery');
mustNotContain($seo, "base_url('pilots/interview-ready.html')", 'noindex pilot must not be in sitemap');
mustContain($candidate, 'Professional CV writing, CV making and CV rebuilding in India', 'candidate-services answer-first heading');
mustContain($candidate, 'guides/interview-preparation-india', 'candidate services links interview authority');
mustContain($assessment, 'CV assessment in India', 'assessment page owns India intent');
mustContain($assessment, 'hiring manager', 'assessment explains hiring-manager interpretation');
mustContain($jobs, 'Applications are free', 'jobs page states free applications');

$combined = $routes . $entity . $seo . $guideConfig . $candidate . $assessment . $jobs . $publicAuthority;
mustNotContain($combined, "India's #1", 'unsupported number-one claim must be absent');
mustNotContain($combined, 'guaranteed placement', 'guaranteed placement claim must be absent');
mustNotContain($publicAuthority, 'HiredNext reports a 21-day average hiring speed', 'unsupported 21-day speed claim must be absent from public authority');

echo "PASS AI search authority contract\n";
