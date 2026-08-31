<?php
$report = $report ?? [];
$lead = $lead ?? [];
$reportVersion = $reportVersion ?? [];
$showControls = $showControls ?? false;
$scoreLabels = [
    'ats_readiness' => 'ATS Readiness',
    'recruiter_scanability' => 'Recruiter Scanability',
    'role_positioning' => 'Role Positioning',
    'evidence_strength' => 'Evidence Strength',
];
$next = $report['recommended_next_step'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= esc($report['report_title'] ?? 'HiredNext CV Assessment Report') ?></title>
<style>
    *{box-sizing:border-box} body{margin:0;background:#eef2f7;color:#172033;font-family:Arial,Helvetica,sans-serif;font-size:13px;line-height:1.55}
    .sheet{max-width:900px;margin:24px auto;background:#fff;box-shadow:0 12px 36px rgba(12,52,102,.10);position:relative;padding:118px 54px 76px}
    .letterhead{position:absolute;left:54px;right:54px;top:34px;border-bottom:2px solid #0c3466;padding-bottom:15px;display:flex;justify-content:space-between;align-items:flex-end}
    .brand-main{font-size:27px;font-weight:800;letter-spacing:-1px;color:#0c3466}.brand-main span{color:#ff4e16}.brand-sub{font-size:10px;font-weight:700;letter-spacing:2.1px;color:#0c3466;margin-top:5px}
    .letterhead-meta{text-align:right;font-size:10px;color:#5b6576;line-height:1.5}.confidential{font-weight:700;color:#0c3466;text-transform:uppercase;letter-spacing:1.1px}
    h1{font-family:Georgia,'Times New Roman',serif;color:#0c3466;font-size:30px;line-height:1.15;margin:0 0 7px} h2{font-family:Georgia,'Times New Roman',serif;color:#0c3466;font-size:19px;margin:25px 0 9px;padding-bottom:6px;border-bottom:1px solid #dbe2ea} h3{font-size:14px;color:#0c3466;margin:0 0 5px}
    .subtitle{color:#5b6576;font-size:12px;margin-bottom:22px}.identity{display:grid;grid-template-columns:1fr 1fr;gap:10px 24px;background:#f6f8fb;border:1px solid #e0e6ee;border-radius:8px;padding:15px 18px;margin:18px 0 22px}.identity label{display:block;font-size:9px;text-transform:uppercase;letter-spacing:1.2px;color:#7c8797;font-weight:700}.identity strong{display:block;color:#172033;font-size:12px;margin-top:2px}
    .verdict{border-left:4px solid #ff4e16;background:#fff8f5;padding:14px 16px;margin:12px 0}.verdict strong{color:#0c3466}.risk{display:inline-block;border-radius:999px;padding:3px 9px;font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;background:#eef2f7;color:#0c3466}
    .scores{width:100%;border-collapse:collapse;margin:10px 0 18px}.scores th,.scores td{padding:9px 10px;border-bottom:1px solid #e6ebf1;text-align:left}.scores th{font-size:10px;color:#677385;text-transform:uppercase;letter-spacing:.7px}.scores td:last-child{font-weight:700;color:#0c3466;width:90px}
    .strengths{margin:8px 0 0;padding-left:20px}.strengths li{margin:5px 0}.finding{padding:14px 0;border-bottom:1px solid #edf0f4;page-break-inside:avoid}.finding:last-child{border-bottom:0}.severity{font-size:9px;text-transform:uppercase;letter-spacing:.8px;font-weight:700;color:#ff4e16}.rowlabel{font-weight:700;color:#0c3466}.evidence{background:#f7f8fa;border-left:3px solid #cbd3dd;padding:9px 11px;margin:7px 0;color:#394457}.recommendation{margin-top:6px}
    .next-step{border:1px solid #d8e0ea;background:#f8fafc;border-radius:9px;padding:17px 18px;margin-top:10px}.price{font-size:18px;font-weight:800;color:#0c3466}.optional{font-size:9px;text-transform:uppercase;letter-spacing:1px;color:#6c7788;font-weight:700}
    .method{margin-top:28px;padding-top:14px;border-top:1px solid #dfe5ec;color:#657185;font-size:10px}.footer{position:absolute;left:54px;right:54px;bottom:28px;border-top:1px solid #dfe5ec;padding-top:8px;color:#6c7788;font-size:9px;display:flex;justify-content:space-between;gap:15px}
    .controls{max-width:900px;margin:18px auto;display:flex;gap:10px}.controls button{border:0;border-radius:8px;padding:10px 15px;background:#0c3466;color:#fff;font-weight:700;cursor:pointer}.controls button.secondary{background:#fff;color:#0c3466;border:1px solid #ccd5e1}
    @media(max-width:700px){.sheet{margin:0;box-shadow:none;padding:112px 22px 75px}.letterhead{left:22px;right:22px}.footer{left:22px;right:22px}.identity{grid-template-columns:1fr}.brand-main{font-size:22px}}
    @media print{body{background:#fff}.controls{display:none!important}.sheet{max-width:none;margin:0;box-shadow:none;padding:108px 48px 68px}.letterhead{position:fixed;top:24px;left:48px;right:48px}.footer{position:fixed;bottom:20px;left:48px;right:48px}@page{size:A4;margin:0}}
</style>
</head>
<body>
<?php if ($showControls): ?>
<div class="controls"><button onclick="window.print()">Print / Save as PDF</button><button class="secondary" onclick="window.history.back()">Back to Admin</button></div>
<?php endif; ?>
<main class="sheet">
    <header class="letterhead">
        <div><div class="brand-main">HIRED<span>NEXT</span></div><div class="brand-sub">RECRUITMENT</div></div>
        <div class="letterhead-meta"><div class="confidential">Confidential Career Document</div><div>hirednext.net · jobs@hirednext.info</div></div>
    </header>

    <h1><?= esc($report['report_title'] ?? 'HiredNext CV Assessment Report') ?></h1>
    <div class="subtitle">Recruiter-informed assessment of the CV submitted to HiredNext.</div>

    <section class="identity">
        <div><label>Candidate</label><strong><?= esc($report['candidate_name'] ?? $lead['name'] ?? '') ?></strong></div>
        <div><label>Report ID</label><strong><?= esc($report['report_id'] ?? ('HN-CV-' . ($lead['id'] ?? ''))) ?></strong></div>
        <div><label>Date</label><strong><?= esc($report['report_date'] ?? date('d M Y')) ?></strong></div>
        <div><label>Target / Job Context</label><strong><?= esc(($report['job_title'] ?? '') ?: 'Not specified') ?></strong></div>
    </section>

    <h2>Recruiter Summary</h2>
    <p><?= esc($report['recruiter_summary'] ?? '') ?></p>
    <div class="verdict"><span class="risk">Shortlist risk: <?= esc($report['shortlist_risk'] ?? 'medium') ?></span><p><strong>HiredNext view:</strong> <?= esc($report['overall_verdict'] ?? '') ?></p></div>

    <?php if (!empty($report['scores'])): ?>
    <h2>Profile Readiness</h2>
    <table class="scores"><thead><tr><th>Assessment area</th><th>Advisory score</th></tr></thead><tbody>
    <?php foreach ($scoreLabels as $key => $label): if (!isset($report['scores'][$key])) continue; ?>
        <tr><td><?= esc($label) ?></td><td><?= esc((string)$report['scores'][$key]) ?>/100</td></tr>
    <?php endforeach; ?>
    </tbody></table>
    <p style="font-size:10px;color:#6d7888">Scores are directional recruiter-readiness signals based on the submitted CV, not statistical probabilities or hiring guarantees.</p>
    <?php endif; ?>

    <?php if (!empty($report['strengths'])): ?>
    <h2>What Is Working</h2><ul class="strengths">
    <?php foreach ($report['strengths'] as $strength): ?><li><?= esc($strength) ?></li><?php endforeach; ?>
    </ul>
    <?php endif; ?>

    <h2>Priority Gaps & Why They Matter</h2>
    <?php foreach (($report['priority_changes'] ?? $report['findings'] ?? []) as $index => $finding): ?>
    <article class="finding">
        <div class="severity"><?= esc($finding['severity'] ?? 'medium') ?> priority</div>
        <h3><?= esc(($index + 1) . '. ' . ($finding['finding'] ?? '')) ?></h3>
        <div class="evidence"><span class="rowlabel">Evidence from the submitted CV:</span> <?= esc($finding['evidence'] ?? '') ?></div>
        <div><span class="rowlabel">Why it matters:</span> <?= esc($finding['why_it_matters'] ?? '') ?></div>
        <div class="recommendation"><span class="rowlabel">Recommended change:</span> <?= esc($finding['recommendation'] ?? '') ?></div>
    </article>
    <?php endforeach; ?>

    <h2>Recommended Next Step</h2>
    <div class="next-step">
        <div class="optional">Optional HiredNext recommendation</div>
        <?php if (!empty($next['service'])): ?>
            <div class="price"><?= esc($next['service']) ?> · ₹<?= esc(number_format((int)($next['price'] ?? 0))) ?></div>
            <p><?= esc($next['reason'] ?? '') ?></p>
            <p><span class="rowlabel">What this would change:</span> <?= esc($next['what_changes'] ?? '') ?></p>
            <p style="font-size:10px;color:#6d7888">This is an optional professional service. It does not affect recruitment consideration, job applications, interviews or placement through HiredNext.</p>
        <?php else: ?>
            <div class="price">No paid rebuild automatically recommended</div><p><?= esc($next['reason'] ?? 'The current CV has a workable base.') ?></p>
        <?php endif; ?>
    </div>

    <div class="method"><strong>Assessment basis:</strong> <?= esc($report['methodology'] ?? '') ?><br><br><?= esc($report['disclaimer'] ?? '') ?></div>

    <footer class="footer"><span>HIREDNEXT RECRUITMENT · hirednext.net</span><span><?= esc($report['report_id'] ?? '') ?> · Confidential</span></footer>
</main>
</body>
</html>
