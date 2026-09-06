const fs = require('fs');
const path = require('path');

const root = path.resolve(__dirname, '..');
const assessmentController = fs.readFileSync(path.join(root, 'app/Controllers/CvAssessment.php'), 'utf8');
const paymentController = fs.readFileSync(path.join(root, 'app/Controllers/CvPayment.php'), 'utf8');
const view = fs.readFileSync(path.join(root, 'app/Views/pages/services/cv-assessment.php'), 'utf8');

const checks = {
  'unpaid checkout does not email founder': !assessmentController.includes("setTo('tarushikha@hirednext.info')"),
  'unpaid checkout does not email candidate': !assessmentController.includes('candidate_acknowledgement'),
  'payment-reference submission owns notifications': paymentController.includes('internal_payment_alert')
    && paymentController.includes('priority_payment_acknowledgement'),
  'unpaid record is only a checkout draft': assessmentController.includes("'status' => 'checkout_started'"),
  'unpaid audit is not marked received': assessmentController.includes("'checkout_started'")
    && !assessmentController.includes("'cv_received'"),
  'page states the payment gate clearly': view.includes('Your assessment request is submitted only after you enter your payment reference')
    && view.includes('Continue to ₹599 payment'),
};

const failed = Object.entries(checks).filter(([, ok]) => !ok).map(([label]) => label);
if (failed.length) {
  console.error(`FAIL: ${failed.join(', ')}`);
  process.exit(1);
}
console.log('PASS: unpaid CV checkout cannot trigger submission emails');
