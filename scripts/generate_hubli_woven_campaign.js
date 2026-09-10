const fs = require('fs');
const path = require('path');
const crypto = require('crypto');
const { execFileSync } = require('child_process');

const root = path.resolve(__dirname, '..');
const assetDir = path.join(root, 'public/theme/assets/jobs');
const campaignDir = path.join(root, 'docs/hiring-campaigns');

const roles = [
  { code: 'HN-HBL-0910-01', title: 'DGM – Operations', lines: ['DGM –', 'OPERATIONS'], experience: '15–20 years', salary: '₹2.5–3.5 lakh / month', positions: 1, qualification: 'BE in Textile or any BE graduate', slug: 'dgm-operations-woven-manufacturing-hubli' },
  { code: 'HN-HBL-0910-02', title: 'Manager – IE', lines: ['MANAGER – IE'], experience: '10–15 years', salary: '₹1.5–1.75 lakh / month', positions: 2, qualification: 'BE in Textile or any BE graduate', slug: 'manager-industrial-engineering-woven-hubli' },
  { code: 'HN-HBL-0910-03', title: 'Manager – Planning', lines: ['MANAGER –', 'PLANNING'], experience: '10–15 years', salary: '₹1–1.25 lakh / month', positions: 1, qualification: 'BE in Textile or any BE graduate', slug: 'manager-planning-woven-manufacturing-hubli' },
  { code: 'HN-HBL-0910-04', title: 'Manager – Quality', lines: ['MANAGER –', 'QUALITY'], experience: '10–15 years', salary: '₹1–1.25 lakh / month', positions: 2, qualification: 'BE in Textile or any BE graduate', slug: 'manager-quality-woven-manufacturing-hubli' },
  { code: 'HN-HBL-0910-05', title: 'Dispatch Executive', lines: ['DISPATCH', 'EXECUTIVE'], experience: '5–10 years', salary: '₹50,000–75,000 / month', positions: 1, qualification: 'PUC / Graduate', slug: 'dispatch-executive-woven-manufacturing-hubli' },
  { code: 'HN-HBL-0910-06', title: 'Assistant Quality Manager', lines: ['ASSISTANT QUALITY', 'MANAGER'], experience: '5–10 years', salary: '₹60,000–75,000 / month', positions: 2, qualification: 'Any graduate', slug: 'assistant-quality-manager-woven-hubli' },
  { code: 'HN-HBL-0910-07', title: 'Assistant Production Manager', lines: ['ASSISTANT', 'PRODUCTION MANAGER'], experience: '5–10 years', salary: '₹75,000–85,000 / month', positions: 1, qualification: 'SSLC', slug: 'assistant-production-manager-woven-hubli' },
  { code: 'HN-HBL-0910-08', title: 'Assistant Manager – IE', lines: ['ASSISTANT', 'MANAGER – IE'], experience: '5–10 years', salary: '₹75,000–85,000 / month', positions: 2, qualification: 'BE in Textile or any BE graduate', slug: 'assistant-manager-industrial-engineering-woven-hubli' },
];

function xml(value) {
  return String(value)
    .replaceAll('&', '&amp;')
    .replaceAll('<', '&lt;')
    .replaceAll('>', '&gt;')
    .replaceAll('"', '&quot;')
    .replaceAll("'", '&apos;');
}

function poster(role) {
  const longestTitleLine = Math.max(...role.lines.map((line) => line.length));
  const titleSize = role.lines.length === 1
    ? (longestTitleLine > 15 ? 70 : 78)
    : (longestTitleLine >= 18 ? 50 : longestTitleLine > 15 ? 56 : 68);
  const titleLines = role.lines.map((line, index) =>
    `<text x="64" y="${375 + index * 86}" font-family="Arial,Helvetica,sans-serif" font-size="${titleSize}" font-weight="800" fill="#071d3d">${xml(line)}</text>`
  ).join('\n');
  const positions = role.positions === 1 ? '1 POSITION' : `${role.positions} POSITIONS`;
  const url = `hirednext.net/jobs/${role.slug}`;

  return `<svg xmlns="http://www.w3.org/2000/svg" width="1200" height="1200" viewBox="0 0 1200 1200" role="img" aria-labelledby="title desc">
<title id="title">${xml(role.title)} | HiredNext apparel and garment manufacturing opening</title>
<desc id="desc">${xml(role.code)}, Hubli / Dharwad, ${xml(role.experience)}, ${xml(role.salary)}, ${positions.toLowerCase()}.</desc>
<defs>
  <linearGradient id="bg" x1="0" y1="0" x2="1" y2="1"><stop offset="0" stop-color="#ffffff"/><stop offset="1" stop-color="#e9f0f7"/></linearGradient>
  <linearGradient id="navy" x1="0" y1="0" x2="1" y2="0"><stop offset="0" stop-color="#061e3f"/><stop offset="1" stop-color="#0d365e"/></linearGradient>
</defs>
<rect width="1200" height="1200" fill="url(#bg)"/>
<rect x="0" y="0" width="1200" height="24" fill="#ff5a1f"/>
<rect x="0" y="1048" width="1200" height="152" fill="url(#navy)"/>

<text x="64" y="108" font-family="Arial,Helvetica,sans-serif" font-size="72" font-weight="700" fill="#071d3d">Hired</text>
<text x="251" y="108" font-family="Arial,Helvetica,sans-serif" font-size="72" font-weight="700" fill="#ff5a1f">Next</text>
<text x="64" y="145" font-family="Arial,Helvetica,sans-serif" font-size="24" font-weight="700" fill="#071d3d">Leadership Recruitment. Delivered.</text>
<rect x="824" y="65" width="312" height="62" rx="14" fill="#071d3d"/>
<text x="980" y="105" text-anchor="middle" font-family="Arial,Helvetica,sans-serif" font-size="24" font-weight="700" fill="#ffffff">${xml(role.code)}</text>

<rect x="64" y="198" width="530" height="58" rx="16" fill="#ff5a1f"/>
<text x="329" y="236" text-anchor="middle" font-family="Arial,Helvetica,sans-serif" font-size="24" font-weight="700" letter-spacing="1" fill="#ffffff">APPAREL / GARMENT MANUFACTURER</text>
<text x="64" y="298" font-family="Arial,Helvetica,sans-serif" font-size="27" font-weight="700" letter-spacing="3" fill="#5b687b">CONFIDENTIAL SEARCH</text>
${titleLines}
<rect x="64" y="${role.lines.length === 1 ? 410 : 497}" width="160" height="8" fill="#ff5a1f"/>

<!-- woven manufacturing visual -->
<rect x="700" y="190" width="436" height="340" rx="28" fill="#071d3d"/>
<path d="M748 450V320l82 42v-78l94 48v-90l95 52v156z" fill="#ffffff" opacity="0.96"/>
<rect x="774" y="385" width="50" height="38" fill="#ff5a1f"/><rect x="850" y="385" width="50" height="38" fill="#ff5a1f"/><rect x="926" y="385" width="50" height="38" fill="#ff5a1f"/>
<path d="M1033 260c42 31 58 71 46 121" stroke="#ff5a1f" stroke-width="13" fill="none" stroke-linecap="round"/>
<text x="918" y="493" text-anchor="middle" font-family="Arial,Helvetica,sans-serif" font-size="23" font-weight="700" fill="#dce8f4">WOVEN MANUFACTURING</text>

<!-- role facts -->
<rect x="64" y="575" width="520" height="124" rx="20" fill="#ffffff" stroke="#d0dae6" stroke-width="2"/>
<text x="92" y="620" font-family="Arial,Helvetica,sans-serif" font-size="21" fill="#607087">LOCATION</text>
<text x="92" y="668" font-family="Arial,Helvetica,sans-serif" font-size="34" font-weight="800" fill="#071d3d">Hubli / Dharwad</text>
<rect x="616" y="575" width="520" height="124" rx="20" fill="#ffffff" stroke="#d0dae6" stroke-width="2"/>
<text x="644" y="620" font-family="Arial,Helvetica,sans-serif" font-size="21" fill="#607087">EXPERIENCE</text>
<text x="644" y="668" font-family="Arial,Helvetica,sans-serif" font-size="34" font-weight="800" fill="#071d3d">${xml(role.experience)}</text>

<rect x="64" y="725" width="520" height="124" rx="20" fill="#071d3d"/>
<text x="92" y="770" font-family="Arial,Helvetica,sans-serif" font-size="21" fill="#cbd8e6">SALARY RANGE</text>
<text x="92" y="818" font-family="Arial,Helvetica,sans-serif" font-size="31" font-weight="800" fill="#ffffff">${xml(role.salary)}</text>
<rect x="616" y="725" width="520" height="124" rx="20" fill="#ff5a1f"/>
<text x="644" y="770" font-family="Arial,Helvetica,sans-serif" font-size="21" fill="#fff1ea">OPENINGS</text>
<text x="644" y="818" font-family="Arial,Helvetica,sans-serif" font-size="34" font-weight="800" fill="#ffffff">${positions}</text>

<rect x="64" y="878" width="1072" height="84" rx="18" fill="#ffffff" stroke="#d0dae6" stroke-width="2"/>
<text x="600" y="930" text-anchor="middle" font-family="Arial,Helvetica,sans-serif" font-size="28" font-weight="700" fill="#071d3d">Minimum 5 years’ woven manufacturing experience</text>

<text x="64" y="1010" font-family="Arial,Helvetica,sans-serif" font-size="23" font-weight="700" fill="#071d3d">APPLY:</text>
<text x="152" y="1010" font-family="Arial,Helvetica,sans-serif" font-size="22" font-weight="700" fill="#ff5a1f">${xml(url)}</text>

<text x="64" y="1110" font-family="Arial,Helvetica,sans-serif" font-size="30" font-weight="700" fill="#ffffff">Send CV with subject:</text>
<text x="64" y="1153" font-family="Arial,Helvetica,sans-serif" font-size="29" font-weight="800" fill="#ff8a5c">${xml(role.code)} | ${xml(role.title)}</text>
<text x="1136" y="1110" text-anchor="end" font-family="Arial,Helvetica,sans-serif" font-size="22" fill="#ffffff">jobs@hirednext.info</text>
<text x="1136" y="1152" text-anchor="end" font-family="Arial,Helvetica,sans-serif" font-size="22" fill="#dbe4ef">www.hirednext.net</text>
</svg>`;
}

fs.mkdirSync(assetDir, { recursive: true });
fs.mkdirSync(campaignDir, { recursive: true });

for (const role of roles) {
  const svgPath = path.join(assetDir, `${role.slug}.svg`);
  const pngPath = path.join(assetDir, `${role.slug}.png`);
  fs.writeFileSync(svgPath, poster(role));
  execFileSync('inkscape', [
    svgPath,
    '--export-type=png',
    `--export-filename=${pngPath}`,
    '--export-width=1200',
    '--export-height=1200',
  ], { stdio: 'ignore' });
}

const intro = `# Hubli Woven Manufacturing Hiring Campaign\n\nPublication channel: HiredNext Recruitment company page only.\n\nConfidential employer. Established apparel / garment manufacturer at Rayapura Industrial Area on National Highway, Hubli. The woven facility has operated since 2018, has approximately 1,500 machines, serves export customers including Levi's, Columbia, H&M, Duluth and Target, and produces shorts, pants, jeans/denim and jackets for women, men and children.\n\n`;
const posts = roles.map((role) => {
  const positions = role.positions === 1 ? '1 position' : `${role.positions} positions`;
  return `## ${role.code} | ${role.title}\n\nHiring: ${role.title} for an established Apparel / Garment Manufacturer.\nHubli / Dharwad | ${role.experience} | ${role.salary}.\n${role.qualification} | Minimum 5 years in woven manufacturing | English, Kannada and Hindi.\n${positions} | Notice period: One to two months.\nApply: https://hirednext.net/jobs/${role.slug} | Email subject: ${role.code} | ${role.title}\n`;
}).join('\n');

fs.writeFileSync(path.join(campaignDir, '2026-09-10-hubli-woven-roles.md'), intro + posts);

const manifest = {};
for (const role of roles) {
  for (const type of ['svg', 'png']) {
    const fileName = `${role.slug}.${type}`;
    const contents = fs.readFileSync(path.join(assetDir, fileName));
    manifest[fileName] = {
      type,
      sha256: crypto.createHash('sha256').update(contents).digest('hex'),
    };
  }
}
fs.writeFileSync(
  path.join(campaignDir, '2026-09-10-hubli-woven-assets.json'),
  `${JSON.stringify(manifest, null, 2)}\n`
);

console.log(`Generated ${roles.length} SVG/PNG posters and ${roles.length} five-line posts.`);
