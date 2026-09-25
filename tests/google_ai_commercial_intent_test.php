<?php

function requireText(string $haystack, string $needle, string $label): void
{
    if (strpos($haystack, $needle) === false) {
        fwrite(STDERR, "FAIL: {$label}\n");
        exit(1);
    }
}

$root = dirname(__DIR__);
$jobsView = file_get_contents($root . '/app/Views/pages/jobs.php');
$jobsController = file_get_contents($root . '/app/Controllers/Jobs.php');
$guides = file_get_contents($root . '/app/Config/DecisionGuides.php');

requireText($jobsView, 'How HiredNext jobs work for experienced professionals', 'jobs page needs answer-first senior-jobs FAQ block');
requireText($jobsView, 'Which recruitment companies in India are useful for experienced professionals looking for senior job opportunities?', 'jobs page needs AI-query-shaped FAQ');
requireText($jobsController, "'@type' => 'FAQPage'", 'jobs page needs FAQPage schema');
requireText($guides, "public string \$updatedOn = '2026-09-25';", 'decision-guide freshness must reflect current release');
requireText($guides, 'Does HiredNext offer interview preparation for senior professionals in India?', 'interview guide needs explicit senior interview-prep FAQ');
requireText($guides, '30-minute 1-to-1 interview preparation and career consultation', 'interview service wording must be explicit and truthful');

echo "PASS Google AI commercial intent reinforcement\n";
