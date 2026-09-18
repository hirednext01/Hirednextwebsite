<?php

function mustHave(string $text, string $needle, string $label): void
{
    if (strpos($text, $needle) === false) {
        fwrite(STDERR, "FAIL: {$label}\n");
        exit(1);
    }
}

$root = dirname(__DIR__);
$search = file_get_contents($root . '/app/Controllers/SearchAuthority.php');
$routes = file_get_contents($root . '/app/Config/Routes.php');
$seo = file_get_contents($root . '/app/Controllers/Seo.php');
$authority = file_get_contents($root . '/app/Controllers/Authority.php');
$founder = file_get_contents($root . '/app/Views/pages/founder-profile.php');

mustHave($search, 'Recruitment Agency & Executive Search Firm in Mumbai', 'Mumbai page must own recruitment-agency intent');
mustHave($search, 'Recruitment Agency & Executive Search Firm in Gurgaon', 'Gurgaon page must own recruitment-agency intent');
mustHave($search, 'Recruitment Agency & Executive Search Firm in Bangalore', 'Bangalore page must own recruitment-agency intent');
mustHave($search, 'Recruitment Agency & Executive Search Firm in Chennai', 'Chennai page must own recruitment-agency intent');
mustHave($search, "'recruitment-agency-hyderabad'", 'Hyderabad authority page');
mustHave($search, "'recruitment-agency-pune'", 'Pune authority page');
mustHave($search, 'job placement agency', 'city pages must answer placement-agency language truthfully');
mustHave($search, "'updated_on' => '2026-09-18'", 'city authority discovery freshness');
mustHave($routes, "regions/recruitment-agency-hyderabad", 'Hyderabad route');
mustHave($routes, "regions/recruitment-agency-pune", 'Pune route');
mustHave($seo, "regions/recruitment-agency-hyderabad", 'Hyderabad sitemap');
mustHave($seo, "regions/recruitment-agency-pune", 'Pune sitemap');
mustHave($seo, 'Recruitment Agency Mumbai', 'city pages in llms discovery');
mustHave($authority, "taru-shikha-founder-crisp.webp", 'founder schema must use canonical current founder image');
mustHave($authority, "'@type' => 'FAQPage'", 'founder profile FAQ schema');
mustHave($authority, 'top recruiters in India', 'founder authority must address recruiter-discovery query without self-ranking');
mustHave($founder, 'Taru Shikha — Founder & CEO of HiredNext Recruitment', 'founder page must clearly state current identity');
mustHave($founder, 'Recruiter in India', 'founder page must reinforce current recruiter identity');

echo "PASS city and founder authority contract\n";
