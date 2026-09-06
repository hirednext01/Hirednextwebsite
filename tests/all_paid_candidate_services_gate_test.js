const fs = require('fs');
const path = require('path');

const root = path.resolve(__dirname, '..');
const checkout = fs.readFileSync(path.join(root, 'app/Controllers/CvServiceCheckout.php'), 'utf8');
const payment = fs.readFileSync(path.join(root, 'app/Controllers/CvUpgrade.php'), 'utf8');
const admin = fs.readFileSync(path.join(root, 'app/Controllers/CvReviewAdmin.php'), 'utf8');
const creator = fs.readFileSync(path.join(root, 'app/Services/Cv/CvCreationAgent.php'), 'utf8');
const delivery = fs.readFileSync(path.join(root, 'app/Controllers/CvStudioDocumentController.php'), 'utf8');
const view = fs.readFileSync(path.join(root, 'app/Views/pages/services/cv-service-start.php'), 'utf8');

const checks = {
  'unpaid public checkout creates only a draft': checkout.includes("'status' => 'checkout_started'")
    && checkout.includes("'public_service_checkout_started'"),
  'unpaid public checkout sends no email': !checkout.includes('sendStartEmails')
    && !checkout.includes("setTo('tarushikha@hirednext.info')"),
  'payment submission owns candidate and internal notifications': payment.includes('sendUpgradePaymentAcknowledgement')
    && payment.includes('sendInternalUpgradeAlert'),
  'fulfilment requires verified payment': admin.includes('Payment must be verified before fulfilment can begin.')
    && admin.includes("!in_array((string) (\$order['status'] ?? ''), ['verified', 'in_fulfilment', 'delivered'], true)"),
  'paid CV generation requires verified order': creator.includes('Payment must be verified before HiredNext can generate this paid CV service.'),
  'paid CV delivery requires verified order': delivery.includes('Payment must be verified before this paid CV can be delivered.'),
  'checkout page states the gate': view.includes('Your service request is submitted only after you pay and enter the transaction reference')
    && view.includes('No request email is sent before payment'),
};

const failed = Object.entries(checks).filter(([, ok]) => !ok).map(([label]) => label);
if (failed.length) {
  console.error(`FAIL: ${failed.join(', ')}`);
  process.exit(1);
}
console.log('PASS: every paid candidate service is gated by payment');
