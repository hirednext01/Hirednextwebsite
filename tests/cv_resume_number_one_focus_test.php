<?php

$root = dirname(__DIR__);
$controller = file_get_contents($root . '/app/Controllers/CandidateServices.php');
$legacy = file_get_contents($root . '/app/Controllers/LegacyCareerRedirects.php');
$product = file_get_contents($root . '/app/Views/pages/services/cv-service-product.php');
$testimonialPath = $root . '/app/Views/pages/services/_cv-rebuild-testimonials.php';

function must(bool $ok, string $label): void {
    if (!$ok) {
        fwrite(STDERR, "FAIL: {$label}\n");
        exit(1);
    }
}

must(str_contains($legacy, "services/professional-cv-rebuild"), 'legacy Avron CV authority redirects to canonical professional CV page');
must(str_contains($controller, 'Professional CV Writing & Resume Writing Service in India'), 'canonical page owns exact CV/resume writing commercial intent');
must(str_contains($controller, 'CV writing service India'), 'canonical page metadata includes exact target phrase');
must(str_contains($controller, 'resume writing service India'), 'canonical page metadata includes resume synonym');
must(str_contains($controller, "'quickAnswer'"), 'professional page has answer-first commercial summary');
must(str_contains($controller, "best-cv-writing-service-india"), 'professional page links to buyer guide');
must(str_contains($controller, "cv-writing-vs-ai-resume-builder-india"), 'professional page links to AI-vs-human guide');
must(str_contains($product, 'Quick answer'), 'shared product page renders answer-first block');
must(str_contains($product, 'Why HiredNext'), 'professional page can render recruiter-side differentiation');
must(str_contains($product, '_cv-rebuild-testimonials'), 'canonical rebuild page can render genuine testimonial evidence');
must(is_file($testimonialPath), 'testimonial evidence partial exists');
must(!str_contains($controller, "India's #1"), 'does not self-award an unsupported number-one ranking');

echo "PASS: CV/resume commercial-intent authority consolidation\n";
