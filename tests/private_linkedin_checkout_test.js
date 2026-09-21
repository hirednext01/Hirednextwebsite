const fs = require('fs');
const path = require('path');

const root = path.resolve(__dirname, '..');
const routes = fs.readFileSync(path.join(root, 'app/Config/Routes.php'), 'utf8');
const controllerPath = path.join(root, 'app/Controllers/PrivateCheckout.php');
const viewPath = path.join(root, 'app/Views/pages/services/linkedin-leadership-payment.php');
const qrPath = path.join(root, 'public/theme/assets/private/hirednext-company-qr.png');

const checks = {
  'private checkout route exists': routes.includes('pay/linkedin-leadership/(:segment)')
    && routes.includes('PrivateCheckout::linkedinLeadership/$1'),
  'private checkout controller exists': fs.existsSync(controllerPath),
  'private checkout view exists': fs.existsSync(viewPath),
  'verified company QR asset exists': fs.existsSync(qrPath),
};

if (fs.existsSync(controllerPath) && fs.existsSync(viewPath)) {
  const controller = fs.readFileSync(controllerPath, 'utf8');
  const view = fs.readFileSync(viewPath, 'utf8');
  const combined = `${controller}\n${view}`;
  Object.assign(checks, {
    'checkout requires exact private token': controller.includes('hash_equals(self::TOKEN, strtolower($token))'),
    'checkout is private and uncached': controller.includes("setHeader('X-Robots-Tag', 'noindex, nofollow, noarchive')")
      && controller.includes("setHeader('Cache-Control', 'no-store, private, max-age=0')"),
    'agreed service and exact calculation are displayed': view.includes('LinkedIn Leadership Positioning')
      && view.includes('₹8,999 + GST')
      && view.includes('₹5,500')
      && view.includes('₹990')
      && view.includes('₹6,490'),
    'verified HiredNext company payee is displayed': view.includes('Hirednext Avron Private Limited')
      && view.includes('hirednext-company-qr.png'),
    'checkout contains no personal payee identity or phone-linked UPI': !combined.toLowerCase().includes('taru shikha')
      && !combined.includes('7738578358')
      && !combined.toLowerCase().includes('@ptaxis'),
    'payment confirmation goes to partnership account': view.includes('partners@hirednext.info'),
  });
}

const failed = Object.entries(checks).filter(([, passed]) => !passed).map(([name]) => name);
if (failed.length) {
  console.error(`FAIL:\n - ${failed.join('\n - ')}`);
  process.exit(1);
}

console.log('PASS: private LinkedIn leadership checkout contract');
