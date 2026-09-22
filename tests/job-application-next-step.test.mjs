import assert from 'node:assert/strict';
import { buildJobApplicationNextStep, isSuccessfulApplication } from '../public/theme/js/job-application-next-step.mjs';

assert.equal(
  isSuccessfulApplication('?applied=1'),
  true,
  'the post-application prompt must activate after a successful application redirect',
);
assert.equal(
  isSuccessfulApplication('?applied=0'),
  false,
  'the paid-service prompt must not replace the form before an application succeeds',
);

const step = buildJobApplicationNextStep('divisional-merchandising-manager-gurgaon');
assert.equal(step.question, 'Does your CV clearly show that you match this JD?');
assert.equal(
  step.assessmentPath,
  '/services/cv-assessment?job=divisional-merchandising-manager-gurgaon&utm_source=job_application_success&utm_medium=website&utm_campaign=cv_jd_match',
  'assessment must retain the exact applied-job context',
);
assert.equal(
  step.rebuildPath,
  '/services/professional-cv-rebuild?utm_source=job_application_success&utm_medium=website&utm_campaign=cv_jd_match_rebuild',
  'rebuild must remain the optional second step',
);
assert.equal(step.skipPath, '/jobs', 'candidate must be able to skip paid services');
assert.match(step.independenceNote, /does not affect shortlisting/i);

console.log('Job application next-step behavior: PASS');
