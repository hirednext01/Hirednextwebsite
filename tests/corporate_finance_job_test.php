<?php

$model = file_get_contents(__DIR__ . '/../app/Models/JobModel.php');
$migrationFiles = glob(__DIR__ . '/../app/Database/Migrations/*CorporateFinanceLead*.php');

$requirements = [
    'corporate-finance-lead-mumbai',
    'Corporate Finance Lead',
    'HN-CFL-0831',
    'Mumbai',
    '₹30–35 LPA',
    'Chartered Accountant',
    'SAP',
    'Retail / Quick Commerce / FMCG / Hospitality',
    'HiredNext does not charge candidates',
];

foreach ($requirements as $requirement) {
    if (strpos($model, $requirement) === false) {
        fwrite(STDERR, "Missing published-job requirement in JobModel: {$requirement}\n");
        exit(1);
    }
}

if (count($migrationFiles) !== 1) {
    fwrite(STDERR, "Expected exactly one Corporate Finance Lead migration.\n");
    exit(1);
}

$migration = file_get_contents($migrationFiles[0]);
foreach ($requirements as $requirement) {
    if (strpos($migration, $requirement) === false) {
        fwrite(STDERR, "Missing durable migration requirement: {$requirement}\n");
        exit(1);
    }
}

if (stripos($model . $migration, 'Food Stories') !== false) {
    fwrite(STDERR, "Confidential client name leaked into published job content.\n");
    exit(1);
}

echo "Corporate Finance Lead publishing contract: PASS\n";
