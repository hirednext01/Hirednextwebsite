import fs from 'node:fs';
import path from 'node:path';
import { fileURLToPath } from 'node:url';

const root = path.resolve(path.dirname(fileURLToPath(import.meta.url)), '..');
const read = (relativePath) => fs.readFileSync(path.join(root, relativePath), 'utf8');
const routes = read('app/Config/Routes.php');
const layout = read('app/Views/layouts/main.php');
const home = read('app/Views/pages/home.php');
const homeController = read('app/Controllers/Home.php');
const homeIndex = homeController.slice(homeController.indexOf('public function index()'), homeController.indexOf('public function about()'));
const jobs = read('app/Views/pages/jobs.php');
const jobModel = read('app/Models/JobModel.php');
const seo = read('app/Controllers/Seo.php');

const checks = new Map([
  ['old /jobs route remains available', routes.includes("$routes->get('jobs', 'Jobs::index')")],
  ['old job detail routes remain available', routes.includes("$routes->get('jobs/(:any)', 'Home::jobDetail/$1')")],
  ['leadership advisory URL remains available', routes.includes("$routes->get('leadership-advisory/cxo-global-leadership-positioning'")],
  ['job-board alias permanently redirects to /jobs', routes.includes("$routes->get('job-board'") && routes.includes("redirect()->to('/jobs', 301)")],
  ['search authority hub is routed', routes.includes("$routes->get('search-authority', 'SearchAuthority::index')")],
  ['desktop navigation separates employers', layout.includes('For Employers')],
  ['desktop navigation separates professionals', layout.includes('For Professionals')],
  ['desktop navigation separates leaders', layout.includes('For CXOs')],
  ['navigation labels /jobs as Job Board', layout.includes('Job Board') && layout.includes("base_url('jobs')")],
  ['mobile navigation is a compact side panel', layout.includes('site-mobile-menu-panel') && layout.includes('max-width: 440px')],
  ['homepage leads with executive recruitment and talent advisory', home.includes('Executive recruitment') && home.includes('talent advisory')],
  ['homepage primary action is hiring mandate', home.includes('Discuss a Hiring Mandate')],
  ['homepage is not a candidate product catalogue', !home.includes('Get My CV Assessed') && !home.includes('Get My CV Rebuilt') && !home.includes('₹992') && !home.includes('₹2,500')],
  ['homepage retains founding and operating facts', home.includes('Founded in Mumbai in 2016') && home.includes('operating base to Gurugram (Gurgaon), Haryana') && home.includes('no public walk-in office')],
  ['homepage does not query unused jobs, reviews or press', !homeIndex.includes('getOpenJobs()') && !homeIndex.includes('loadActiveReviews()') && !homeIndex.includes('loadActivePressMedia()')],
  ['homepage schema does not publish invisible FAQ content', !homeIndex.includes("'@type' => 'FAQPage'")],
  ['job board uses Job Board label', jobs.includes('HiredNext Job Board')],
  ['job board does not claim every listing is an active employer mandate', !jobs.includes('Active employer mandates managed by HiredNext Recruitment')],
  ['job board does not expose expression-of-interest language', !jobs.toLowerCase().includes('expression of interest') && !jobModel.toLowerCase().includes('expression of interest')],
  ['job board does not expose future-mandate language', !jobs.toLowerCase().includes('upcoming mandate') && !jobModel.toLowerCase().includes('upcoming mandate')],
  ['job card primary action is Apply for this role', jobs.includes('Apply for this role')],
  ['search authority page exists', fs.existsSync(path.join(root, 'app/Views/pages/search-authority.php'))],
  ['search authority hub is discoverable in sitemap', seo.includes("base_url('search-authority')")],
]);

const failed = [...checks].filter(([, passed]) => !passed);
for (const [label, passed] of checks) {
  console.log(`${passed ? 'PASS' : 'FAIL'}: ${label}`);
}

if (failed.length) {
  process.exitCode = 1;
}
