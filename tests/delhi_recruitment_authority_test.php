<?php

$root = dirname(__DIR__);
$routes = file_get_contents($root . '/app/Config/Routes.php');
$search = file_get_contents($root . '/app/Controllers/SearchAuthority.php');
$seo = file_get_contents($root . '/app/Controllers/Seo.php');
$indexNow = file_get_contents($root . '/.github/workflows/indexnow.yml');
$view = file_get_contents($root . '/app/Views/pages/search-authority.php');

function must(bool $ok, string $label): void {
    if (!$ok) {
        fwrite(STDERR, "FAIL: {$label}\n");
        exit(1);
    }
}

must(str_contains($routes, "regions/recruitment-agency-delhi"), 'Delhi recruitment route exists');
must(str_contains($search, "'recruitment-agency-delhi'"), 'Delhi authority config exists');
must(str_contains($search, "Recruitment Agency & Executive Search Firm in Delhi / NCR"), 'Delhi intent title exists');
must(str_contains($search, "operates from Gurgaon"), 'Delhi page preserves truthful operating-base context');
must(str_contains($search, "no public walk-in office"), 'Delhi page does not imply a Delhi storefront');
must(str_contains($search, "CXO and functional heads"), 'Delhi page has leadership role coverage');
must(str_contains($search, "GCC and shared-services leadership"), 'Delhi page has GCC role coverage');

must(str_contains($seo, "regions/recruitment-agency-delhi"), 'Delhi page included in sitemap/llms discovery');
must(str_contains($indexNow, "https://hirednext.net/regions/recruitment-agency-delhi"), 'Delhi page submitted to IndexNow');
must(str_contains($view, "Delhi / NCR"), 'Delhi page receives relevant internal-link treatment');

echo "PASS: Delhi NCR recruitment authority contract\n";
