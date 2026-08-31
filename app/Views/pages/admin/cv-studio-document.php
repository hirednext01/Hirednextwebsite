<?php
$template = $document['template_key'] ?? 'ats_classic';
$executive = $template === 'executive_ats';
$modern = $template === 'ats_modern';
$branding = ($document['branding_mode'] ?? 'remove') === 'keep';
$name = $lead['name'] ?? 'Candidate';
$target = $content['target_title'] ?? '';
$headline = $content['headline'] ?? '';
$summary = $content['summary'] ?? '';
$skills = $content['core_skills'] ?? [];
$experience = $content['experience'] ?? [];
$achievements = $content['selected_achievements'] ?? [];
$education = $content['education'] ?? [];
$certifications = $content['certifications'] ?? [];
$tools = $content['tools'] ?? [];
$board = $content['board_highlights'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= esc($name) ?> — CV</title>
<style>
@page { size: A4; margin: 14mm 15mm 14mm; }
* { box-sizing: border-box; }
body { margin:0; background:#eef1f5; color:#172033; font-family:Arial,Helvetica,sans-serif; font-size:10.5pt; line-height:1.42; }
.sheet { width:210mm; min-height:297mm; margin:18px auto; background:#fff; padding:15mm 16mm 13mm; box-shadow:0 5px 30px rgba(15,31,55,.12); }
.top { padding-bottom:12px; border-bottom:2px solid #0c3466; }
.name { color:#0c3466; font-family:Georgia,'Times New Roman',serif; font-size:28pt; line-height:1; font-weight:700; letter-spacing:.2px; }
.target { margin-top:6px; color:#bd6500; font-weight:700; font-size:10.5pt; letter-spacing:.5px; text-transform:uppercase; }
.contact { margin-top:8px; color:#4b5563; font-size:8.5pt; }
.section { margin-top:15px; }
.section-title { color:#0c3466; font-size:10pt; line-height:1.2; font-weight:800; letter-spacing:.65px; text-transform:uppercase; padding-bottom:4px; border-bottom:1px solid #bfc8d5; }
.summary { margin-top:7px; }
.skills { margin-top:7px; color:#25364d; }
.skill { display:inline; }
.skill + .skill:before { content:'  •  '; color:#bd6500; }
.role { margin-top:11px; }
.role-head { display:flex; justify-content:space-between; gap:16px; align-items:flex-start; }
.role-company { color:#0c3466; font-weight:800; }
.role-title { font-weight:700; margin-top:1px; }
.role-dates { color:#4b5563; font-size:8.5pt; white-space:nowrap; text-align:right; }
ul { margin:5px 0 0 18px; padding:0; }
li { margin:2px 0; }
.simple-list { margin-top:6px; }
.footer { margin-top:18px; padding-top:8px; border-top:1px solid #d8dee8; text-align:center; color:#7a8595; font-size:7.5pt; }
.controls { width:210mm; margin:18px auto 0; display:flex; gap:8px; justify-content:flex-end; font-family:Arial,sans-serif; }
.controls button { border:0; border-radius:8px; padding:9px 14px; background:#0c3466; color:#fff; font-weight:700; cursor:pointer; }

/* Modern remains single source-order and ATS-safe; styling alone creates hierarchy. */
.modern .top { border-bottom:3px solid #ff4e16; }
.modern .name { font-family:Arial,Helvetica,sans-serif; font-size:25pt; letter-spacing:-.4px; }
.modern .section-title { border-bottom:0; border-left:4px solid #ff4e16; padding:3px 0 3px 8px; background:#f7f8fa; }
.modern .role { border-left:2px solid #e2e6ec; padding-left:10px; }

/* Executive uses a strong candidate-owned top band; contact info remains in body. */
.executive.sheet { padding-top:0; }
.executive .top { margin:0 -16mm; padding:14mm 16mm 11mm; background:#0c3466; border:0; }
.executive .name { color:#fff; text-align:center; font-size:29pt; }
.executive .target { color:#f2a34f; text-align:center; }
.executive .contact { color:#e9edf4; text-align:center; }
.executive .section-title { font-size:10.5pt; border-bottom:2px solid #0c3466; }
.executive .impact { margin-top:7px; padding:8px 10px; background:#f6f8fb; border-left:4px solid #bd6500; }

@media print {
  body { background:#fff; }
  .sheet { margin:0; width:auto; min-height:auto; box-shadow:none; padding:0; }
  .executive .top { margin-left:0; margin-right:0; }
  .controls { display:none !important; }
}
</style>
</head>
<body>
<?php if (!empty($preview) && empty($wordExport)): ?><div class="controls"><button onclick="window.print()">Print / Save PDF</button></div><?php endif; ?>
<div class="sheet <?= $modern ? 'modern' : '' ?> <?= $executive ? 'executive' : '' ?>">
    <div class="top">
        <div class="name"><?= esc($name) ?></div>
        <?php if ($target || $headline): ?><div class="target"><?= esc($target ?: $headline) ?></div><?php endif; ?>
        <div class="contact"><?= esc($lead['email'] ?? '') ?><?= !empty($lead['phone']) ? '  |  ' . esc($lead['phone']) : '' ?></div>
    </div>

    <?php if ($summary): ?>
    <section class="section"><div class="section-title"><?= $executive ? 'Executive Profile' : 'Professional Summary' ?></div><div class="summary"><?= nl2br(esc($summary)) ?></div></section>
    <?php endif; ?>

    <?php if ($executive && $achievements): ?>
    <section class="section"><div class="section-title">Leadership Impact</div><div class="impact"><ul><?php foreach ($achievements as $item): ?><li><?= esc($item) ?></li><?php endforeach; ?></ul></div></section>
    <?php endif; ?>

    <?php if ($skills): ?>
    <section class="section"><div class="section-title"><?= $executive ? 'Functional Expertise' : 'Core Competencies' ?></div><div class="skills"><?php foreach ($skills as $skill): ?><span class="skill"><?= esc($skill) ?></span><?php endforeach; ?></div></section>
    <?php endif; ?>

    <?php if ($experience): ?>
    <section class="section"><div class="section-title">Professional Experience</div>
        <?php foreach ($experience as $role): ?>
            <div class="role"><div class="role-head"><div><div class="role-company"><?= esc($role['company'] ?? '') ?></div><div class="role-title"><?= esc($role['title'] ?? '') ?><?= !empty($role['location']) ? ' · ' . esc($role['location']) : '' ?></div></div><div class="role-dates"><?= esc($role['dates'] ?? '') ?></div></div><?php if (!empty($role['bullets'])): ?><ul><?php foreach ($role['bullets'] as $bullet): ?><li><?= esc($bullet) ?></li><?php endforeach; ?></ul><?php endif; ?></div>
        <?php endforeach; ?>
    </section>
    <?php endif; ?>

    <?php if (!$executive && $achievements): ?><section class="section"><div class="section-title">Selected Achievements</div><ul class="simple-list"><?php foreach ($achievements as $item): ?><li><?= esc($item) ?></li><?php endforeach; ?></ul></section><?php endif; ?>
    <?php if ($board): ?><section class="section"><div class="section-title">Board / Strategic Highlights</div><ul class="simple-list"><?php foreach ($board as $item): ?><li><?= esc($item) ?></li><?php endforeach; ?></ul></section><?php endif; ?>
    <?php if ($education): ?><section class="section"><div class="section-title">Education</div><ul class="simple-list"><?php foreach ($education as $item): ?><li><?= esc($item) ?></li><?php endforeach; ?></ul></section><?php endif; ?>
    <?php if ($certifications): ?><section class="section"><div class="section-title">Certifications</div><ul class="simple-list"><?php foreach ($certifications as $item): ?><li><?= esc($item) ?></li><?php endforeach; ?></ul></section><?php endif; ?>
    <?php if ($tools): ?><section class="section"><div class="section-title">Tools / Platforms</div><div class="skills"><?php foreach ($tools as $tool): ?><span class="skill"><?= esc($tool) ?></span><?php endforeach; ?></div></section><?php endif; ?>

    <?php if ($branding): ?><div class="footer">Prepared with HiredNext Career Services · hirednext.net</div><?php endif; ?>
</div>
</body>
</html>
