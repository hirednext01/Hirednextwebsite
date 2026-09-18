import fs from 'node:fs';

const root = new URL('../', import.meta.url);
const pageUrl = new URL('../public/pilots/career-intelligence.html', import.meta.url);
const layout = fs.readFileSync(new URL('../app/Views/layouts/main.php', import.meta.url), 'utf8');
const seoController = fs.readFileSync(new URL('../app/Controllers/Seo.php', import.meta.url), 'utf8');

const failures = [];
const requireCondition = (condition, message) => {
  if (!condition) failures.push(message);
};

requireCondition(fs.existsSync(pageUrl), 'Hidden Career Intelligence page must exist.');

if (fs.existsSync(pageUrl)) {
  const html = fs.readFileSync(pageUrl, 'utf8');
  const visibleText = html.replace(/<[^>]+>/g, ' ').replace(/\s+/g, ' ').trim();

  requireCondition(/<meta\s+name="robots"\s+content="noindex,nofollow,noarchive">/i.test(html), 'Page must be noindex, nofollow and noarchive.');
  requireCondition(html.includes('HiredNext Career Intelligence'), 'Page must use the HiredNext Career Intelligence name.');
  requireCondition(/Your experience deserves to be seen—and valued\s*—at the level it has earned\./.test(visibleText), 'Hero promise is missing.');
  requireCondition(html.includes('11+ years'), 'HiredNext recruitment experience proof is missing.');
  requireCondition(html.includes('Recruiter-led. Evidence-based. AI-assisted. Human-reviewed.'), 'Service method proof is missing.');

  for (const pathway of ['Position My Profile', 'Prepare Me to Win', 'Understand My Market Value']) {
    requireCondition(html.includes(pathway), `Missing pathway: ${pathway}`);
  }

  for (const offer of ['CV Assessment', 'ATS CV Optimisation', 'Professional CV Rebuild', 'Premium Leadership CV', 'C-Suite Positioning Suite', '1:1 Interview Strategy', 'Human-Led Career Cohort', 'AI Career Lab', 'Salary Benchmark Report', 'Salary Negotiation Session']) {
    requireCondition(html.includes(offer), `Missing offer: ${offer}`);
  }

  for (const price of ['₹599', '₹999', '₹1,799', '₹3,999', '₹8,999', '₹2,999', '₹1,499']) {
    requireCondition(html.includes(price), `Missing launch price: ${price}`);
  }

  requireCondition(html.includes('first 100 verified redemptions'), 'Complimentary first-100 assessment rule is missing.');
  requireCondition(html.includes('/services/cv-assessment?utm_source=career_intelligence'), '₹599 assessment must link to the live assessment flow.');
  requireCondition(html.includes('/career-services/start/ats_999?utm_source=career_intelligence'), '₹999 optimisation must link to the live checkout.');
  requireCondition(html.includes('/career-services/start/rebuild_1799?utm_source=career_intelligence'), '₹1,799 rebuild must link to the live checkout.');
  requireCondition(html.includes('/api/contact/submit'), 'Preview services must use the existing lead capture endpoint.');
  requireCondition(html.includes('Your CV goes directly to HiredNext'), 'Direct HiredNext data handling promise is missing.');
  requireCondition(html.includes('Zepto receives campaign-level reporting'), 'Partner reporting boundary is missing.');
  requireCondition(html.includes('registering interest'), 'Unlaunched services must be described as interest registration.');
  requireCondition(!html.includes('better luck next time'), 'Page must not use a negative scratch-card message.');
}

requireCondition(!layout.includes('pilots/career-intelligence.html'), 'Hidden page must not appear in public navigation.');
requireCondition(!seoController.includes('pilots/career-intelligence.html'), 'Hidden page must not appear in the XML sitemap.');

if (failures.length) {
  console.error(`FAIL\n - ${failures.join('\n - ')}`);
  process.exit(1);
}

console.log('PASS hidden Career Intelligence page contract');
