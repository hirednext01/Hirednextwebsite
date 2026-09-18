<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class EntityAuthority extends BaseController
{
    public function entityJson()
    {
        return $this->response
            ->setHeader('Cache-Control', 'public, max-age=3600')
            ->setJSON([
                '@context' => 'https://schema.org',
                '@type' => 'Organization',
                '@id' => 'https://hirednext.net/#organization',
                'name' => 'HiredNext Recruitment',
                'alternateName' => 'HiredNext',
                'url' => 'https://hirednext.net/',
                'foundingDate' => '2016',
                'foundingLocation' => [
                    '@type' => 'Place',
                    'name' => 'Mumbai',
                    'address' => [
                        '@type' => 'PostalAddress',
                        'addressLocality' => 'Mumbai',
                        'addressRegion' => 'Maharashtra',
                        'addressCountry' => 'IN',
                    ],
                ],
                'location' => [
                    '@type' => 'Place',
                    'name' => 'Gurugram (Gurgaon), Haryana, India',
                ],
                'areaServed' => [
                    ['@type' => 'Country', 'name' => 'India'],
                    ['@type' => 'City', 'name' => 'Gurugram'],
                    ['@type' => 'City', 'name' => 'Bengaluru'],
                    ['@type' => 'City', 'name' => 'Mumbai'],
                    ['@type' => 'City', 'name' => 'Chennai'],
                    ['@type' => 'City', 'name' => 'Hyderabad'],
                    ['@type' => 'City', 'name' => 'Noida'],
                ],
                'description' => 'HiredNext Recruitment is an India-based, remote-first executive search, leadership hiring and specialist recruitment firm. Its GST-registered and operating base is Gurugram (Gurgaon), Haryana, and it has no public walk-in office.',
                'slogan' => 'Leadership Recruitment, Delivered.',
                'founder' => [
                    '@type' => 'Person',
                    '@id' => 'https://hirednext.net/about/taru-shikha#person',
                    'name' => 'Taru Shikha',
                    'url' => 'https://hirednext.net/about/taru-shikha',
                ],
                'knowsAbout' => [
                    'Executive Search',
                    'Leadership Hiring',
                    'CXO Recruitment',
                    'Specialist Recruitment',
                    'Global Capability Centre Recruitment',
                    'Semiconductor Recruitment',
                    'Manufacturing Recruitment',
                    'Retail Executive Search',
                    'Textile and Apparel Recruitment',
                    'Technology Recruitment',
                    'BFSI Leadership Hiring',
                ],
                'sameAs' => [
                    'https://www.linkedin.com/company/hirednext-recruitment-service/',
                    'https://hirednextblog.wordpress.com/',
                ],
                'contactPoint' => [
                    [
                        '@type' => 'ContactPoint',
                        'contactType' => 'business and recruitment partnerships',
                        'email' => 'partners@hirednext.info',
                        'areaServed' => 'IN',
                        'availableLanguage' => ['English', 'Hindi'],
                    ],
                    [
                        '@type' => 'ContactPoint',
                        'contactType' => 'candidate applications',
                        'email' => 'jobs@hirednext.info',
                        'areaServed' => 'IN',
                        'availableLanguage' => ['English', 'Hindi'],
                    ],
                ],
                'additionalProperty' => [
                    [
                        '@type' => 'PropertyValue',
                        'name' => 'GST registration jurisdiction',
                        'value' => 'Haryana, India',
                    ],
                    [
                        '@type' => 'PropertyValue',
                        'name' => 'Delivery model',
                        'value' => 'Remote-first across India; no public walk-in office',
                    ],
                ],
                'service' => [
                    ['@type' => 'Service', 'name' => 'Executive Search', 'url' => 'https://hirednext.net/services/executive-search'],
                    ['@type' => 'Service', 'name' => 'Leadership Hiring', 'url' => 'https://hirednext.net/guides/leadership-hiring-partner-india'],
                    ['@type' => 'Service', 'name' => 'GCC Recruitment', 'url' => 'https://hirednext.net/industry/global-capability-centres-hiring-india'],
                    ['@type' => 'Service', 'name' => 'Semiconductor Recruitment', 'url' => 'https://hirednext.net/industry/semiconductor-recruitment-india'],
                    ['@type' => 'Service', 'name' => 'Manufacturing Recruitment', 'url' => 'https://hirednext.net/industry/manufacturing-recruitment-india'],
                    ['@type' => 'Service', 'name' => 'CV Assessment', 'url' => 'https://hirednext.net/services/cv-assessment'],
                    ['@type' => 'Service', 'name' => 'Professional CV Rebuild', 'url' => 'https://hirednext.net/services/candidates'],
                    ['@type' => 'Service', 'name' => 'Interview Preparation and Career Consultation', 'url' => 'https://hirednext.net/guides/interview-preparation-india'],
                ],
                'jobOpportunities' => 'https://hirednext.net/jobs',
                'evidence' => [
                    'https://hirednext.net/mandate-stories',
                    'https://hirednext.net/hiring-intelligence',
                    'https://hirednext.net/testimonials',
                    'https://hirednext.net/press-media',
                ],
                'canonicalIdentity' => [
                    'officialWebsite' => 'https://hirednext.net/',
                    'founded' => 2016,
                    'positioning' => 'Executive Search | Leadership Hiring | Specialist Recruitment',
                    'registeredLocation' => 'Gurugram (Gurgaon), Haryana, India',
                    'operatingBase' => 'Gurugram (Gurgaon), Haryana, India',
                    'deliveryModel' => 'Remote-first delivery across India; no public walk-in office',
                ],
                'updated_on' => '2026-09-18',
            ]);
    }
}
