<?php

namespace CodeIgniter\Config {
    if (!class_exists(BaseConfig::class)) {
        class BaseConfig
        {
        }
    }
}

namespace {
    require_once __DIR__ . '/../app/Config/BrandFacts.php';

    $brandFacts = new \Config\BrandFacts();

    $expectedDisclosure = 'HiredNext Recruitment is a proprietorship firm · GSTIN 06AIJPA3944J1ZB.';

    if (($brandFacts->facts['legal_name'] ?? null) !== 'HiredNext Recruitment') {
        fwrite(STDERR, "Incorrect HiredNext legal name.\n");
        exit(1);
    }

    if (($brandFacts->facts['business_structure'] ?? null) !== 'Proprietorship firm') {
        fwrite(STDERR, "Incorrect or missing HiredNext business structure.\n");
        exit(1);
    }

    if (($brandFacts->facts['gstin'] ?? null) !== '06AIJPA3944J1ZB') {
        fwrite(STDERR, "Incorrect or missing HiredNext GSTIN.\n");
        exit(1);
    }

    if (!method_exists($brandFacts, 'legalDisclosure') || $brandFacts->legalDisclosure() !== $expectedDisclosure) {
        fwrite(STDERR, "Incorrect public legal disclosure.\n");
        exit(1);
    }

    $schemaIdentity = method_exists($brandFacts, 'organizationSchemaIdentity')
        ? $brandFacts->organizationSchemaIdentity()
        : [];

    if ($schemaIdentity !== [
        'legalName' => 'HiredNext Recruitment',
        'taxID' => '06AIJPA3944J1ZB',
    ]) {
        fwrite(STDERR, "Incorrect machine-readable legal identity.\n");
        exit(1);
    }

    echo "HiredNext legal identity contract: PASS\n";
}
