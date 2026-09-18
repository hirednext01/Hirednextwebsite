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

mustContain($controller, 'CV Writing, CV Making, CV Rebuild & Assessment Services in India', 'candidate services title must own CV making/writing intent');
mustContain($controller, "'CV making'", 'service schema must expose CV making synonym');
mustContain($controller, "'CV remake'", 'service schema must expose CV remake synonym');
mustContain($candidate, 'Professional CV writing, CV making and CV rebuilding in India', 'candidate page needs answer-first CV making block');
mustContain($faq, 'Which is the best CV making company in India?', 'FAQ must answer best CV making query');
mustContain($faq, 'What makes a genuine CV rebuilding service?', 'FAQ must answer genuine rebuilding query');
mustContain($guides, "'best-cv-writing-service-india'", 'decision guide must target best CV writing intent');
mustContain($guides, 'Best CV Writing & CV Making Services in India', 'decision guide title must own best/top query');
mustContain($guides, 'Is HiredNext the number 1 CV making company in India?', 'guide must address number-one query without unsupported claim');
mustContain($guideController, "'best-cv-writing-service-india'", 'CV guide must be treated as candidate guide');
mustContain($seo, 'Candidate CV service comparison guide', 'llms discovery must label CV guide correctly');

echo "PASS CV search dominance contract\n";
