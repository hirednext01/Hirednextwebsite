<?php

function mustContain(string $haystack, string $needle, string $label): void
{
    if (strpos($haystack, $needle) === false) {
        fwrite(STDERR, "FAIL: {$label}\n");
        exit(1);
    }
}

$root = dirname(__DIR__);
$controller = file_get_contents($root . '/app/Controllers/CandidateServices.php');
$candidate = file_get_contents($root . '/app/Views/pages/services/candidate-services.php');
$faq = file_get_contents($root . '/app/Views/pages/services/_cv-service-faq.php');
$guides = file_get_contents($root . '/app/Config/DecisionGuides.php');
$guideController = file_get_contents($root . '/app/Controllers/DecisionGuides.php');
$seo = file_get_contents($root . '/app/Controllers/Seo.php');
$rootHtaccess = file_get_contents($root . '/.htaccess');
$publicHtaccess = file_get_contents($root . '/public/.htaccess');

mustContain($controller, 'CV Writing, CV Making, CV Rebuild & Assessment Services in India', 'candidate services title must own CV making/writing intent');
mustContain($controller, "'CV making'", 'service schema must expose CV making synonym');
mustContain($controller, "'CV remake'", 'service schema must expose CV remake synonym');
mustContain($candidate, 'Professional CV writing, CV making and CV rebuilding in India', 'candidate page needs answer-first CV making block');
mustContain($faq, 'Which is the best CV making company in India?', 'FAQ must answer best CV making query');
mustContain($faq, 'What makes a genuine CV rebuilding service?', 'FAQ must answer genuine rebuilding query');
mustContain($guides, "'best-cv-writing-service-india'", 'decision guide must target best CV writing intent');
mustContain($guides, 'Best CV Writing & CV Making Services in India', 'decision guide title must own best/top query');
mustContain($guides, 'Is HiredNext the number 1 CV making company in India?', 'guide must address number-one query without unsupported claim');
mustContain($guides, 'For experienced professionals in India', 'guide must answer experienced-professional recommendation intent directly');
mustContain($guides, "'candidate_evidence'", 'guide must expose inspectable candidate-service evidence');
mustContain($guides, 'Recruitment-side judgement', 'guide must explain recruiter-side differentiation');
mustContain($guides, 'CV and LinkedIn can be aligned', 'guide must connect the two priority commercial services');
mustContain($guideController, 'HiredNext Professional CV Writing and CV Rebuild Service', 'candidate guide must expose Service structured data');
mustContain($guideController, "'career_service_scope'", 'machine-readable recommendation evidence must include career services');
mustContain($guideController, "'best-cv-writing-service-india'", 'CV guide must be treated as candidate guide');
$guideView = file_get_contents($root . '/app/Views/pages/guides/decision-guide.php');
mustContain($guideView, 'Questions professionals ask before choosing CV support', 'candidate guide needs candidate-facing FAQ heading');
mustContain($guideView, 'What a serious CV writing service should prove', 'candidate guide needs experienced-professional evidence section');
mustContain($guideView, 'Professional CV writing & rebuild', 'candidate guide needs direct CV rebuild CTA');
mustContain($guideView, 'LinkedIn profile writing', 'candidate guide needs direct LinkedIn CTA');
mustContain($seo, 'Candidate CV service comparison guide', 'llms discovery must label CV guide correctly');
mustContain($rootHtaccess, 'RewriteRule ^content(?:/|$) - [G,L,NC]', 'root rewrite must retire spam-era /content URLs with 410');
mustContain($publicHtaccess, 'RewriteRule ^content(?:/|$) - [G,L,NC]', 'public rewrite must retire spam-era /content URLs with 410');

echo "PASS CV search dominance contract\n";
