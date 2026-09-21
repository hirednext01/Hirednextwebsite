<?php
$cvQuestions = [
    ['Which is the best CV making company in India?', 'There is no independently verified universal number-one CV company for every professional. Compare providers on recruiter or hiring-manager perspective, evidence discipline, role-specific rewriting, ATS-safe structure, transparent scope, revisions and whether they avoid inventing achievements or guaranteeing interviews. HiredNext publishes its scope and pricing so you can compare it on those criteria.'],
    ['What makes a genuine CV rebuilding service?', 'A genuine rebuild should do more than reformat or add keywords. It should understand the target role, extract verified career evidence, distinguish responsibilities from outcomes, clarify scale and ownership, preserve factual accuracy, use ATS-safe structure and give you a review or revision path. It should not invent metrics or promise a job.'],
    ['What is the difference between CV making, CV writing, CV remake and CV rebuild?', 'In the Indian market these phrases are often used for overlapping services. At HiredNext, CV rebuild means a managed rewrite and restructure based on your verified experience. CV assessment is the detailed written diagnosis step. The ₹2,500 + GST rebuild includes the internal analysis needed to write the document, while the separate written assessment is available on its own or in the 5%-off bundle.'],
    ['What do I get for ₹992 + GST?', 'A written CV assessment covering role alignment, readability, structure and evidence gaps, with prioritised corrections. This is a diagnosis of your current CV, not a complete rewrite. The rounded GST-inclusive payable amount is ₹1,171.'],
    ['Can I make the corrections myself?', 'Yes. The ₹992 + GST assessment is designed to tell you what the current CV communicates, what remains unclear and what to fix first. You can make those corrections yourself; a rebuild is optional.'],
    ['What do I get for ₹2,500 + GST?', 'The Professional CV Rebuild includes the analysis required to build the document, an evidence-led rewrite based on your actual experience, two finished CV variants and two revision rounds. The rounded GST-inclusive payable amount is ₹2,950.'],
    ['What is the Assessment + Rebuild Bundle?', 'The separate base prices total ₹3,492 + GST. The bundle is ₹3,317.40 + GST, a 5% saving, and includes both the detailed written assessment and the full managed CV rebuild.'],
    ['Do I have to buy both?', 'No. Choose the ₹992 + GST assessment if you want the detailed written diagnosis, the ₹2,500 + GST rebuild if you want HiredNext to do the rewrite, or the discounted bundle if you want both deliverables.'],
    ['Can you tell me why an employer rejected my CV?', 'We can identify what your CV leaves unclear or fails to demonstrate for your target role. We cannot know an employer’s private rejection reason or guarantee how their screening system will respond.'],
    ['What should I upload?', 'Your current CV as a PDF, DOC or DOCX, up to 5MB, and the role you are targeting. Add a job description if you have one. We use the facts you provide and ask for clarification rather than inventing achievements.'],
    ['How do I pay?', 'Complete the service intake first. HiredNext then provides the current verified business payment instructions from jobs@hirednext.info. After paying the amount shown, submit the transaction/reference number on the payment page.'],
    ['I submitted a UPI reference. Is my payment confirmed?', 'Submitting a reference records your request; it does not confirm that money arrived. Payment remains pending until HiredNext verifies receipt. For help, email jobs@hirednext.info from the email used for your request and include your request ID.'],
    ['When will I receive my assessment?', 'The ₹992 + GST assessment has a 12-hour delivery window after payment verification. Delivery is by email. Rebuild timing is confirmed separately after the team has your source CV and the information needed for the rewrite.'],
    ['Will buying a service get me shortlisted for a job?', 'No. Applying for HiredNext jobs and securing placement remain free. CV services are optional and do not influence recruitment consideration or referral. There is no guarantee of shortlisting, interviews or a job.'],
];
?>
<section id="cv-questions" class="py-14 bg-white">
    <div class="max-w-[900px] mx-auto px-4 sm:px-8 lg:px-12">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-serif font-bold text-primary">Questions before you buy?</h2>
            <p class="mt-3 text-gray-600">Choose a question for an instant answer.</p>
        </div>
        <div class="space-y-3">
            <?php foreach ($cvQuestions as [$question, $answer]): ?>
                <details class="bg-gray-50 border border-gray-200 rounded-2xl p-5">
                    <summary class="font-bold text-primary cursor-pointer focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-4"><?= esc($question) ?></summary>
                    <p class="mt-3 text-gray-600 text-sm leading-relaxed"><?= esc($answer) ?></p>
                </details>
            <?php endforeach; ?>
        </div>
        <p class="mt-6 text-center text-sm text-gray-600">Looking for a job? <a class="font-bold text-primary underline" href="<?= base_url('jobs') ?>">View current openings</a>.</p>
    </div>
</section>
<script type="application/ld+json"><?= json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => array_map(static fn (array $item): array => [
        '@type' => 'Question', 'name' => $item[0],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => $item[1]],
    ], $cvQuestions),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?></script>
