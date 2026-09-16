import assert from "node:assert/strict";
import { existsSync, readFileSync } from "node:fs";
import test from "node:test";

const model = readFileSync(
  new URL("../app/Models/JobModel.php", import.meta.url),
  "utf8",
);

const jobs = [
  {
    slug: "divisional-merchandising-manager-gurgaon",
    code: "HN-DMM-0915",
    poster: "divisional-merchandising-manager-gurgaon.svg",
  },
  {
    slug: "apparel-designer-gurgaon",
    code: "HN-AD-0915",
    poster: "apparel-designer-gurgaon.svg",
  },
];

for (const job of jobs) {
  test(`${job.code} is a confidential public job with an application route`, () => {
    assert.match(model, new RegExp(`'${job.slug}'\\s*=>`));
    assert.match(model, new RegExp(job.code));
    assert.match(model, new RegExp(job.poster.replaceAll(".", "\\.")));
    assert.match(model, new RegExp(`mailto:jobs@hirednext\\.info\\?subject=[^']*${job.code}`));
  });

  test(`${job.code} has a social poster with the required facts`, () => {
    const posterUrl = new URL(
      `../public/theme/assets/jobs/${job.poster}`,
      import.meta.url,
    );
    assert.equal(existsSync(posterUrl), true);
    const poster = readFileSync(posterUrl, "utf8");
    assert.match(poster, /GURGAON/);
    assert.match(poster, /EXPERIENCE/);
    assert.match(poster, /(CTC|SALARY)/);
    assert.match(poster, /jobs@hirednext\.info/);
    assert.doesNotMatch(poster, /PDS|Krayons/i);
  });
}
