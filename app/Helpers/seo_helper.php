<?php

if (!function_exists('hirednext_schema')) {
    function hirednext_schema(): string
    {
        $schema = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'Organization',
                    '@id' => 'https://hirednext.net/#organization',
                    'name' => 'HiredNext Recruitment',
                    'url' => 'https://hirednext.net/',
                    'description' => 'HiredNext is a talent advisory and recruitment firm specializing in executive search, leadership hiring and specialist recruitment across India.',
                    'founder' => [
                        '@type' => 'Person',
                        'name' => 'Taru Shikha',
                    ],
                    'sameAs' => [
                        'https://www.linkedin.com/company/hirednext-recruitment-service/',
                    ],
                ],
                [
                    '@type' => 'WebSite',
                    '@id' => 'https://hirednext.net/#website',
                    'url' => 'https://hirednext.net/',
                    'name' => 'HiredNext',
                    'publisher' => [
                        '@id' => 'https://hirednext.net/#organization',
                    ],
                ],
            ],
        ];

        return json_encode(
            $schema,
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE
        );
    }
}
