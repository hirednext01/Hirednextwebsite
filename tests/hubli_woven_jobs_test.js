const fs = require('fs');
const path = require('path');

const root = path.resolve(__dirname, '..');
const modelPath = path.join(root, 'app/Models/JobModel.php');
const migrationPath = path.join(
  root,
  'app/Database/Migrations/2026-09-10-193000_PublishHubliWovenManufacturingRoles.php'
);
const campaignPath = path.join(
  root,
  'docs/hiring-campaigns/2026-09-10-hubli-woven-roles.md'
);
const deployWorkflowPath = path.join(root, '.github/workflows/hostinger-production-deploy.yml');

const roles = [
  ['HN-HBL-0910-01', 'DGM – Operations', 'dgm-operations-woven-manufacturing-hubli'],
  ['HN-HBL-0910-02', 'Manager – IE', 'manager-industrial-engineering-woven-hubli'],
  ['HN-HBL-0910-03', 'Manager – Planning', 'manager-planning-woven-manufacturing-hubli'],
  ['HN-HBL-0910-04', 'Manager – Quality', 'manager-quality-woven-manufacturing-hubli'],
  ['HN-HBL-0910-05', 'Dispatch Executive', 'dispatch-executive-woven-manufacturing-hubli'],
  ['HN-HBL-0910-06', 'Assistant Quality Manager', 'assistant-quality-manager-woven-hubli'],
  ['HN-HBL-0910-07', 'Assistant Production Manager', 'assistant-production-manager-woven-hubli'],
  ['HN-HBL-0910-08', 'Assistant Manager – IE', 'assistant-manager-industrial-engineering-woven-hubli'],
];

function requireFile(filePath) {
  if (!fs.existsSync(filePath)) {
    throw new Error(`Missing required file: ${path.relative(root, filePath)}`);
  }
  return fs.readFileSync(filePath, 'utf8');
}

const model = requireFile(modelPath);
const migration = requireFile(migrationPath);
const campaign = requireFile(campaignPath);
const deployWorkflow = requireFile(deployWorkflowPath);
const combined = `${model}\n${migration}\n${campaign}`;

for (const [code, title, slug] of roles) {
  for (const content of [model, migration]) {
    if (!content.includes(code) || !content.includes(title) || !content.includes(slug)) {
      throw new Error(`Missing durable job definition for ${code}`);
    }
  }

  const posterPath = path.join(root, `public/theme/assets/jobs/${slug}.svg`);
  const poster = requireFile(posterPath);
  for (const required of [code, title, 'APPAREL / GARMENT MANUFACTURER', 'Hubli / Dharwad']) {
    if (!poster.includes(required)) {
      throw new Error(`Poster ${slug}.svg is missing: ${required}`);
    }
  }

  const pngPath = path.join(root, `public/theme/assets/jobs/${slug}.png`);
  if (!fs.existsSync(pngPath)) {
    throw new Error(`Missing LinkedIn-ready PNG poster: ${slug}.png`);
  }
  const png = fs.readFileSync(pngPath);
  if (png.length < 8 || png.subarray(0, 8).toString('hex') !== '89504e470d0a1a0a') {
    throw new Error(`Invalid PNG poster: ${slug}.png`);
  }

  const url = `https://hirednext.net/jobs/${slug}`;
  if (!campaign.includes(url) || !campaign.includes(`${code} | ${title}`)) {
    throw new Error(`Campaign copy is missing URL or subject heading for ${code}`);
  }
}

for (const required of [
  'Rayapura Industrial Area',
  'National Highway',
  '1,500 machines',
  'since 2018',
  "Levi's",
  'Columbia',
  'H&amp;M',
  'Duluth',
  'Target',
  'shorts, pants, jeans/denim and jackets',
  'women, men and children',
  'Minimum 5 years in woven manufacturing',
  'English, Kannada and Hindi',
  'One to two months',
]) {
  if (!combined.includes(required)) {
    throw new Error(`Missing supplied campaign detail: ${required}`);
  }
}

if (/shahi/i.test(combined)) {
  throw new Error('Confidential employer name leaked into Hubli campaign content.');
}

const jobDefinitionCount = (migration.match(/'code'\s*=>\s*'HN-HBL-0910-/g) || []).length;
if (jobDefinitionCount !== 8) {
  throw new Error(`Expected 8 Hubli job definitions, found ${jobDefinitionCount}`);
}

for (const command of [
  'php -l app/Models/JobModel.php',
  'php -l app/Database/Migrations/2026-09-10-193000_PublishHubliWovenManufacturingRoles.php',
  'node tests/hubli_woven_jobs_test.js',
]) {
  if (!deployWorkflow.includes(command)) {
    throw new Error(`Hostinger deployment does not verify: ${command}`);
  }
}

console.log('Hubli woven manufacturing campaign contract: PASS (8 roles, employer confidential)');
