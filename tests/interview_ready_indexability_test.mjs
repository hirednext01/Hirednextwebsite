import fs from 'node:fs';

const html = fs.readFileSync(new URL('../public/pilots/interview-ready.html', import.meta.url), 'utf8');
const seoController = fs.readFileSync(new URL('../app/Controllers/Seo.php', import.meta.url), 'utf8');

const failures = [];
const requireCondition = (condition, message) => {
  if (!condition) failures.push(message);
};

requireCondition(
  /<meta\s+name="robots"\s+content="index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1">/i.test(html),
  'Interview Ready must be indexable because it is promoted across public HiredNext pages.',
);
requireCondition(
  /<link\s+rel="canonical"\s+href="https:\/\/hirednext\.net\/pilots\/interview-ready\.html">/i.test(html),
  'Interview Ready must declare its canonical public URL.',
);
requireCondition(
  seoController.includes("base_url('pilots/interview-ready.html')"),
  'The main XML sitemap must include Interview Ready.',
);
requireCondition(
  seoController.includes("'best-recruitment-company-in-india-why-hirednext-recruitment-leads-in-2026'"),
  'The redirected legacy blog slug must be explicitly excluded from sitemap output.',
);

if (failures.length) {
  console.error(`FAIL\n - ${failures.join('\n - ')}`);
  process.exit(1);
}

console.log('PASS Interview Ready indexability contract');
