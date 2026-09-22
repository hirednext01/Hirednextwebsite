const fs = require('fs');
const path = require('path');

const root = path.resolve(__dirname, '..');
const routes = fs.readFileSync(path.join(root, 'app/Config/Routes.php'), 'utf8');
const controllerPath = path.join(root, 'app/Controllers/PrivateCheckout.php');
const viewPath = path.join(root, 'app/Views/pages/services/linkedin-leadership-payment.php');
const gatePath = path.join(root, 'app/Views/components/business-payment-gate.php');

const checks = {
  'private checkout route exists': routes.includes('pay/linkedin-leadership/(:segment)')
    && routes.includes('PrivateCheckout::linkedinLeadership/$1'),
  'private checkout controller exists': fs.existsSync(controllerPath),
  'private checkout view exists': fs.existsSync(viewPath),
  'central business payment gate exists': fs.existsSync(gatePath),
};

if (fs.existsSync(controllerPath) && fs.existsSync(viewPath)) {
  const controller = fs.readFileSync(controllerPath, 'utf8');
  const view = fs.readFileSync(viewPath, 'utf8');
  Object.assign(checks, {
    'checkout requires exact private token': controller.includes('hash_equals(self::TOKEN, strtolower($token))'),
    'checkout is private and uncached': controller.includes("setHeader('X-Robots-Tag', 'noindex, nofollow, noarchive')")
      && controller.includes("setHeader('Cache-Control', 'no-store, private, max-age=0')"),
    'agreed service and exact calculation are displayed': view.includes('LinkedIn Leadership Positioning')
      && view.includes('₹8,999 + GST')
      && view.includes('₹5,500')
      && view.includes('₹990')
      && view.includes('₹6,490'),
    'checkout uses only the central payment gate': view.includes("components/business-payment-gate")
      && !view.includes('hirednext-company-qr.png')
      && !/<img[^>]+(?:qr|upi|payment)/i.test(view),
    'payment confirmation goes to partnership account': view.includes('partners@hirednext.info'),
  });
}

const failed = Object.entries(checks).filter(([, passed]) => !passed).map(([name]) => name);
if (failed.length) {
  console.error(`FAIL:\n - ${failed.join('\n - ')}`);
  process.exit(1);
}
console.log('PASS: private LinkedIn leadership checkout uses central business payment gate');
