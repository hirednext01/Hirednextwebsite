<?php
$cvQuestions = [
    ['What do I get for ₹599?', 'A written CV assessment covering role alignment, readability, structure and evidence gaps, with prioritised corrections. This is a diagnosis of your current CV, not a complete rewrite. GST is included.'],
    ['Can I make the corrections myself?', 'Yes. The ₹599 assessment is designed to tell you what the current CV communicates, what remains unclear and what to fix first. You can make those corrections yourself; a paid rebuild is optional.'],
    ['What do I get for ₹1,799?', 'The Professional CV Rebuild includes an assessment, a rewrite based on your actual experience, two finished CV variants and two revision rounds. GST is included.'],
    ['Do I have to buy both?', 'No. Choose the ₹599 assessment if you want to understand what needs attention first. If you already want a rewritten CV, you can choose the ₹1,799 rebuild directly: assessment is included. Buying both is not compulsory.'],
    ['Can you tell me why an employer rejected my CV?', 'We can identify what your CV leaves unclear or fails to demonstrate for your target role. We cannot know an employer’s private rejection reason or guarantee how their screening system will respond.'],
    ['What should I upload?', 'Your current CV as a PDF, DOC or DOCX, up to 5MB, and the role you are targeting. Add a job description if you have one. We use the facts you provide and ask for clarification rather than inventing achievements.'],
    ['How do I pay?', 'Use the service intake, then scan the HiredNext UPI QR with your UPI app. Pay the amount shown and submit your transaction/reference number on the payment page.'],
    ['I submitted a UPI reference. Is my payment confirmed?', 'Submitting a reference records your request; it does not confirm that money arrived. Payment remains pending until HiredNext verifies receipt. For help, email jobs@hirednext.info from the email used for your request and include your request ID.'],
    ['When will I receive my assessment?', 'The ₹599 assessment has a 12-hour delivery window after payment verification. Delivery is by email. Rebuild timing is confirmed separately after the team has your source CV and the information needed for the rewrite.'],
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
