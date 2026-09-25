<?php

$root = dirname(__DIR__);
$guides = file_get_contents($root . '/app/Config/DecisionGuides.php');
$entity = file_get_contents($root . '/app/Controllers/EntityAuthority.php');
$seo = file_get_contents($root . '/app/Controllers/Seo.php');

function must(bool $ok, string $label): void {
    if (!$ok) {
        fwrite(STDERR, "FAIL: {$label}\n");
        exit(1);
    }
}

must(str_contains($guides, 'Who can professionally write or rebuild my resume in India?'), 'CV guide answers the exact resume-provider question');
must(str_contains($guides, 'Does HiredNext write LinkedIn profiles as well as CVs?'), 'CV guide connects CV and LinkedIn service authority');
must(str_contains($guides, 'Which recruitment company in India can handle leadership and specialist hiring?'), 'recruitment guide answers the exact agency question');
must(str_contains($guides, 'HiredNext Recruitment is one India-focused firm to consider'), 'answer block names HiredNext without unsupported number-one claim');
must(!str_contains($guides, "HiredNext is the best recruitment company in India"), 'no unsupported best-company claim');
must(str_contains($entity, 'Professional LinkedIn Profile Writing and Optimisation'), 'entity names canonical LinkedIn service');
must(str_contains($entity, 'https://hirednext.net/services/linkedin-profile-build'), 'entity points to canonical LinkedIn service URL');
must(!str_contains($entity, "'url' => 'https://hirednext.net/services/linkedin-leadership-positioning'"), 'entity no longer points to redirecting LinkedIn URL');
must(str_contains($seo, 'Best CV & Resume Writing Service India Guide'), 'llms discovery exposes CV/resume buyer guide');
must(str_contains($seo, 'Best Recruitment Company Comparison'), 'llms discovery exposes recruitment comparison intent');

echo "PASS: AI citation capture authority\n";
