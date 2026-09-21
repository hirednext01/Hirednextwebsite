<?php

$root = dirname(__DIR__);
$routes = file_get_contents($root . '/app/Config/Routes.php');
$configPath = $root . '/app/Config/CareerAuthority.php';
$controllerPath = $root . '/app/Controllers/CareerAuthority.php';
$viewPath = $root . '/app/Views/pages/career-authority.php';
$hubPath = $root . '/app/Views/pages/career-intelligence.php';
$seo = file_get_contents($root . '/app/Controllers/Seo.php');
$linkedin = file_get_contents($root . '/app/Views/pages/services/linkedin-leadership.php');
$candidates = file_get_contents($root . '/app/Views/pages/services/candidate-services.php');

function need(bool $ok, string $label): void {
    if (!$ok) {
        fwrite(STDERR, "FAIL: {$label}\n");
        exit(1);
    }
}

need(is_file($configPath), 'CareerAuthority config exists');
need(is_file($controllerPath), 'CareerAuthority controller exists');
need(is_file($viewPath), 'career authority page view exists');
need(is_file($hubPath), 'career intelligence hub exists');

need(str_contains($routes, "career-intelligence"), 'career intelligence hub route');
need(str_contains($routes, "guides/linkedin-profile-optimisation-india"), 'LinkedIn optimisation guide route');
need(str_contains($routes, "guides/executive-linkedin-profile-india"), 'executive LinkedIn guide route');
need(str_contains($routes, "guides/cv-assessment-vs-cv-rebuild"), 'assessment vs rebuild guide route');
need(str_contains($routes, "guides/cv-writing-vs-ai-resume-builder-india"), 'CV vs AI guide route');
need(str_contains($routes, "guides/how-recruiters-read-senior-cv-india"), 'senior CV guide route');
need(str_contains($routes, "authority/career-intelligence.json"), 'AI-readable career authority endpoint');

$config = is_file($configPath) ? file_get_contents($configPath) : '';
foreach ([
    'linkedin-profile-optimisation-india',
    'executive-linkedin-profile-india',
    'cv-assessment-vs-cv-rebuild',
    'cv-writing-vs-ai-resume-builder-india',
    'how-recruiters-read-senior-cv-india',
] as $slug) {
    need(str_contains($config, $slug), "config contains {$slug}");
}
need(str_contains($config, 'short_answer'), 'answer-engine short answers');
need(str_contains($config, 'HiredNext sees'), 'proprietary recruiter perspective');
need(str_contains($config, 'Taru Shikha'), 'founder authorship');
need(str_contains($config, 'linkedin-leadership-positioning'), 'LinkedIn service conversion link');
need(str_contains($config, 'cv-assessment-rebuild-bundle'), 'CV bundle conversion link');

$controller = is_file($controllerPath) ? file_get_contents($controllerPath) : '';
need(str_contains($controller, "'@type' => 'Article'"), 'Article structured data');
need(str_contains($controller, "'@type' => 'BreadcrumbList'"), 'breadcrumb structured data');
need(!str_contains($controller, "'@type' => 'FAQPage'"), 'no deprecated FAQ rich-result schema dependency');

$view = is_file($viewPath) ? file_get_contents($viewPath) : '';
need(str_contains($view, 'Quick answer'), 'visible concise AI answer block');
need(str_contains($view, 'What HiredNext sees'), 'visible HiredNext evidence perspective');
need(str_contains($view, 'Related career intelligence'), 'cluster internal linking');
need(str_contains($view, 'Reviewed by Taru Shikha'), 'visible author/reviewer identity');

need(str_contains($seo, 'CareerAuthority'), 'sitemap/llms source career authority config');
need(str_contains($seo, 'career-intelligence'), 'career authority exposed in discovery');
need(str_contains($linkedin, 'career-intelligence'), 'LinkedIn service links into authority cluster');
need(str_contains($candidates, 'career-intelligence'), 'career services hub links into authority cluster');

echo "PASS: HiredNext career AI-search authority cluster contract\n";
