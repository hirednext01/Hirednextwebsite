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
const manifestPath = path.join(root, 'docs/hiring-campaigns/2026-09-10-hubli-woven-assets.json');
const crypto = require('crypto');

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
const assetManifest = JSON.parse(requireFile(manifestPath));
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
  if (!poster.includes('y="375"') || !poster.includes('CONFIDENTIAL SEARCH')) {
    throw new Error(`Poster ${slug}.svg does not preserve safe title spacing.`);
  }

  const pngPath = path.join(root, `public/theme/assets/jobs/${slug}.png`);
  if (!fs.existsSync(pngPath)) {
    throw new Error(`Missing LinkedIn-ready PNG poster: ${slug}.png`);
  }
  const png = fs.readFileSync(pngPath);
  if (png.length < 8 || png.subarray(0, 8).toString('hex') !== '89504e470d0a1a0a') {
    throw new Error(`Invalid PNG poster: ${slug}.png`);
  }
  for (const [kind, filePath, contents] of [
    ['svg', posterPath, Buffer.from(poster)],
    ['png', pngPath, png],
  ]) {
    const digest = crypto.createHash('sha256').update(contents).digest('hex');
    const key = path.basename(filePath);
    if (assetManifest[key]?.sha256 !== digest || assetManifest[key]?.type !== kind) {
      throw new Error(`Asset manifest is stale for ${key}`);
    }
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

const downMethod = migration.match(/public function down\(\)[\s\S]*?\n    }/);
if (!downMethod || /->delete\s*\(/.test(downMethod[0])) {
  throw new Error('Hubli migration rollback must not delete jobs or candidate applications.');
}

const deployTestCount = (deployWorkflow.match(/node tests\/hubli_woven_jobs_test\.js/g) || []).length;
if (deployTestCount !== 1) {
  throw new Error('Hubli Node contract test must run on GitHub only, before the Hostinger pull.');
}

if (campaign.includes('**')) {
  throw new Error('LinkedIn campaign copy must be plain text without Markdown emphasis markers.');
}

console.log('Hubli woven manufacturing campaign contract: PASS (8 roles, employer confidential)');
