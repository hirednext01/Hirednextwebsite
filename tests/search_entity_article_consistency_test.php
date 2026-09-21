<?php

$root = dirname(__DIR__);
$brand = file_get_contents($root . '/app/Config/BrandFacts.php');
$entity = file_get_contents($root . '/app/Controllers/EntityAuthority.php');
$home = file_get_contents($root . '/app/Controllers/Home.php');
$career = file_get_contents($root . '/app/Controllers/CareerAuthority.php');
$layout = file_get_contents($root . '/app/Views/layouts/main.php');

function ok(bool $value, string $label): void {
    if (!$value) {
        fwrite(STDERR, "FAIL: {$label}\n");
        exit(1);
    }
}

ok(str_contains($brand, "'founder_title' => 'Founder & CEO'"), 'Founder title is canonical Founder & CEO');

ok(str_contains($entity, "'LinkedIn Leadership Positioning'"), 'Entity knows LinkedIn leadership positioning');
ok(str_contains($entity, "'Assessment + CV Rebuild Bundle'"), 'Entity exposes CV bundle');
ok(str_contains($entity, "'Career Intelligence'"), 'Entity exposes career intelligence');
ok(str_contains($entity, "'updated_on' => '2026-09-21'"), 'Entity freshness date updated');

ok(str_contains($home, "'logo' => base_url('theme/assets/logo.jpeg')"), 'Homepage organization schema has logo');
ok(str_contains($home, "'sameAs' => [") && str_contains($home, "founder_linkedin"), 'Founder schema links to founder LinkedIn');
ok(str_contains($home, "'jobTitle' => \$brand['founder_title']"), 'Homepage founder title comes from canonical facts');

ok(str_contains($career, "'ogType' => 'article'"), 'Career pages emit article OpenGraph type');
ok(str_contains($career, "'articleAuthor' => 'Taru Shikha'"), 'Career pages emit author meta');
ok(str_contains($career, "'publishedTime' => \$config->updatedOn"), 'Career pages emit published time');
ok(str_contains($career, "'modifiedTime' => \$config->updatedOn"), 'Career pages emit modified time');
ok(str_contains($career, "'sameAs' => ['https://www.linkedin.com/in/tarushikhaarora']"), 'Article author schema links to founder identity');

ok(str_contains($layout, 'Career Intelligence'), 'Career Intelligence is linked from global site chrome');
ok(!str_contains($layout, 'CV Assessment · ₹599'), 'Global chrome has no stale CV assessment price');

echo "PASS: SEO/AEO/GEO entity and article metadata consistency\n";
