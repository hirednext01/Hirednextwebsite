const fs = require('fs');
const path = require('path');

const root = path.resolve(__dirname, '..');
const candidateServices = fs.readFileSync(
  path.join(root, 'app/Views/pages/services/candidate-services.php'),
  'utf8',
);
const testimonialPartial = path.join(
  root,
  'app/Views/pages/services/_cv-rebuild-testimonials.php',
);

if (!candidateServices.includes("pages/services/_cv-rebuild-testimonials")) {
  throw new Error('Candidate services must include the CV Rebuild testimonial section.');
}

if (!fs.existsSync(testimonialPartial)) {
  throw new Error('CV Rebuild testimonial section is missing.');
}

const view = fs.readFileSync(testimonialPartial, 'utf8');
const checks = {
  'identifies Firdaus as the feedback source': view.includes('Firdaus Jahan'),
  'uses Firdaus’s approved LinkedIn wording': view.includes('leadership journey had gone unspoken'),
  'keeps a three-story capacity': view.includes('$testimonialCapacity = 3'),
  'does not render future empty testimonial cards': view.includes("'published' => false")
    && view.includes('array_filter(')
    && view.includes('$testimonials,'),
};

const failed = Object.entries(checks)
  .filter(([, passed]) => !passed)
  .map(([name]) => name);

if (failed.length) {
  throw new Error(`CV Rebuild testimonial contract failed: ${failed.join(', ')}`);
}

console.log('PASS: Firdaus CV Rebuild testimonial is publishable with two future slots.');
