<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<section class="min-h-[70vh] pt-32 pb-20 bg-gray-50"><div class="max-w-[700px] mx-auto px-4 sm:px-8"><div class="bg-white rounded-[2rem] border border-gray-200 p-8 md:p-12 shadow-sm text-center"><p class="text-accent text-xs font-black uppercase tracking-[0.25em] mb-4">Priority CV Assessment</p><h1 class="text-4xl font-serif font-bold text-primary mb-4">Complete your ₹599 payment</h1><p class="text-gray-600 mb-8">Your CV has been received. Complete payment to activate the 12-hour priority assessment.</p><div class="rounded-2xl bg-gray-50 p-5 text-left mb-8"><div class="flex justify-between py-2"><span class="text-gray-500">Candidate</span><strong><?= esc($lead['name']) ?></strong></div><div class="flex justify-between py-2"><span class="text-gray-500">Service</span><strong>Priority CV Assessment</strong></div><div class="flex justify-between py-2"><span class="text-gray-500">Amount</span><strong>₹599</strong></div></div><button id="pay-button" class="w-full bg-accent text-white py-4 rounded-xl font-bold hover:opacity-90 transition">Pay ₹599 securely</button><p class="text-xs text-gray-500 mt-5">Payments are processed securely by Razorpay.</p></div></div></section>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script><script>
document.getElementById('pay-button').addEventListener('click', function () {
    const options = {key: <?= json_encode($keyId) ?>, amount: 59900, currency: 'INR', name: 'HiredNext Recruitment', description: 'Priority CV Assessment', order_id: <?= json_encode($orderId) ?>, prefill: {name: <?= json_encode($lead['name']) ?>, email: <?= json_encode($lead['email']) ?>, contact: <?= json_encode($lead['phone']) ?>}, theme: {color: '#0c3466'}, handler: function (response) {
        const form = document.createElement('form'); form.method = 'POST'; form.action = <?= json_encode(base_url('cv-payment/verify')) ?>;
        [['lead_id', <?= json_encode($lead['id']) ?>], ['razorpay_payment_id', response.razorpay_payment_id], ['razorpay_order_id', response.razorpay_order_id], ['razorpay_signature', response.razorpay_signature]].forEach(function (pair) { const input = document.createElement('input'); input.type = 'hidden'; input.name = pair[0]; input.value = pair[1]; form.appendChild(input); }); document.body.appendChild(form); form.submit();
    }
    }; new Razorpay(options).open();
});
</script>
<?= $this->endSection() ?>
