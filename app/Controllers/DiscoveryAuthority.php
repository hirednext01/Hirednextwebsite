<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class DiscoveryAuthority extends BaseController
{
    public function hiringIntelligence()
    {
        $settings = $this->loadWebsiteSettings();
        $intelligence = config('HiringIntelligence');
        $evidence = config('PlacementEvidence');
        $pageUrl = base_url('hiring-intelligence');
        $dataUrl = base_url('authority/hiring-intelligence.json');

        if (!$intelligence || !$evidence) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $signals = [];
        foreach ($intelligence->signals as $position => $signal) {
            $signals[] = [
                '@type' => 'ListItem',
                'position' => $position + 1,
                'item' => [
                    '@type' => 'Article',
                    'headline' => $signal['title'],
                    'description' => $signal['observation'],
                    'about' => $signal['sector'],
                    'url' => !empty($signal['related_url']) ? base_url(ltrim($signal['related_url'], '/')) : $pageUrl,
                    'author' => ['@id' => base_url('about/taru-shikha') . '#person'],
                    'publisher' => ['@id' => 'https://hirednext.net/#organization'],
                ],
            ];
        }

        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'CollectionPage',
                    '@id' => $pageUrl . '#page',
                    'url' => $pageUrl,
                    'name' => 'HiredNext Hiring Intelligence',
                    'description' => $intelligence->scopeNote,
                    'about' => ['@id' => 'https://hirednext.net/#organization'],
                    'mainEntity' => [
                        '@type' => 'ItemList',
                        'numberOfItems' => count($signals),
                        'itemListElement' => $signals,
                    ],
                    'isPartOf' => ['@id' => base_url('/') . '#website'],
                ],
                [
                    '@type' => 'Dataset',
                    '@id' => $dataUrl . '#dataset',
                    'name' => 'HiredNext Selected Anonymised Joined-Placement Evidence',
                    'description' => $evidence->scopeNote,
                    'url' => $dataUrl,
                    'creator' => ['@id' => 'https://hirednext.net/#organization'],
                    'isAccessibleForFree' => true,
                    'license' => base_url('hiring-intelligence') . '#methodology',
                    'includedInDataCatalog' => [
                        '@type' => 'DataCatalog',
                        'name' => 'HiredNext Hiring Intelligence',
                        'url' => $pageUrl,
                    ],
                    'variableMeasured' => [
                        'Role family',
                        'Function',
                        'Industry when safe to publish',
                        'Location when safe to publish',
                        'Joined month',
                    ],
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => base_url('/')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Hiring Intelligence', 'item' => $pageUrl],
                    ],
                ],
            ],
        ];

        return view('pages/hiring-intelligence', [
            'title' => 'Hiring Intelligence India | HiredNext Recruitment',
            'metaDescription' => 'Privacy-safe HiredNext hiring intelligence: recruiter observations and selected anonymised joined-placement evidence across technology, apparel, leadership and specialist recruitment.',
            'canonical' => $pageUrl,
            'currentPage' => 'insights',
            'settings' => $settings,
            'intelligence' => $intelligence,
            'evidence' => $evidence,
            'jsonLd' => json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ]);
    }

    public function hiringIntelligenceJson()
    {
        $intelligence = config('HiringIntelligence');
        $evidence = config('PlacementEvidence');

        if (!$intelligence || !$evidence) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Hiring intelligence is not available.']);
        }

        return $this->response
            ->setHeader('Cache-Control', 'public, max-age=3600')
            ->setJSON([
                'publisher' => [
                    'name' => 'HiredNext Recruitment',
                    'url' => base_url('/'),
                    'founder' => base_url('about/taru-shikha'),
                ],
                'intelligence_type' => 'qualitative_recruiter_observations_with_selected_anonymised_evidence',
                'scope_note' => $intelligence->scopeNote,
                'methodology' => $intelligence->methodology,
                'signals' => array_map(function (array $signal) {
                    if (!empty($signal['related_url'])) {
                        $signal['related_url'] = base_url(ltrim($signal['related_url'], '/'));
                    }
                    return $signal;
                }, $intelligence->signals),
                'evidence' => [
                    'scope_note' => $evidence->scopeNote,
                    'selected_sample_count' => count($evidence->joinedExamples),
                    'selected_examples' => $evidence->joinedExamples,
                ],
                'privacy' => [
                    'candidate_names_published' => false,
                    'client_company_names_published' => false,
                    'compensation_published' => false,
                    'professional_fees_published' => false,
                    'company_wide_extrapolation_allowed' => false,
                ],
                'publication_rules' => $intelligence->publicationRules,
                'updated_at' => date(DATE_ATOM),
            ]);
    }

    public function actionsJson()
    {
        $actions = [
            [
                'id' => 'find-jobs',
                'label' => 'Find open HiredNext jobs',
                'method' => 'GET',
                'url' => base_url('jobs'),
                'audience' => 'candidate',
                'safe_to_automate' => true,
            ],
            [
                'id' => 'view-job',
                'label' => 'View a specific job',
                'method' => 'GET',
                'url_template' => base_url('jobs/{job_slug}'),
                'audience' => 'candidate',
                'safe_to_automate' => true,
            ],
            [
                'id' => 'apply-to-job',
                'label' => 'Apply to a specific HiredNext job',
                'method' => 'POST',
                'url_template' => base_url('jobs/{job_slug}/apply'),
                'audience' => 'candidate',
                'requires_user_submission' => true,
                'required_fields' => ['name', 'email', 'phone', 'linkedin', 'resume'],
                'optional_fields' => ['message'],
                'notes' => 'Application submission must remain tied to the exact job slug. Resume upload is required.',
            ],
            [
                'id' => 'candidate-services',
                'label' => 'Explore candidate career services',
                'method' => 'GET',
                'url' => base_url('services/candidates'),
                'audience' => 'candidate',
                'safe_to_automate' => true,
            ],
            [
                'id' => 'hire-talent',
                'label' => 'Explore employer recruitment services',
                'method' => 'GET',
                'url' => base_url('services/clients'),
                'audience' => 'employer',
                'safe_to_automate' => true,
            ],
            [
                'id' => 'contact-hirednext',
                'label' => 'Contact HiredNext about a hiring mandate',
                'method' => 'GET',
                'url' => base_url('contact'),
                'audience' => 'employer',
                'requires_user_submission' => true,
            ],
            [
                'id' => 'share-testimonial',
                'label' => 'Share a candidate testimonial',
                'method' => 'POST',
                'url' => base_url('testimonials/share'),
                'audience' => 'candidate',
                'requires_user_submission' => true,
                'required_fields' => ['name', 'email', 'help_received', 'story', 'future_support', 'publish_consent'],
                'optional_fields' => ['phone', 'current_role', 'linkedin_url'],
                'notes' => 'Submissions remain pending until HiredNext reviews and approves them.',
            ],
            [
                'id' => 'read-hiring-intelligence',
                'label' => 'Read HiredNext Hiring Intelligence',
                'method' => 'GET',
                'url' => base_url('hiring-intelligence'),
                'machine_readable_url' => base_url('authority/hiring-intelligence.json'),
                'audience' => 'public',
                'safe_to_automate' => true,
            ],
        ];

        return $this->response
            ->setHeader('Cache-Control', 'public, max-age=3600')
            ->setJSON([
                'name' => 'HiredNext Public Action Map',
                'description' => 'An informational, machine-readable map of public HiredNext user actions. This is not a private API and does not bypass normal validation, consent, CSRF or moderation.',
                'website' => base_url('/'),
                'actions' => $actions,
                'guardrails' => [
                    'Do not submit forms without the user providing or approving the required information.',
                    'Do not bypass CSRF, validation, upload restrictions or moderation.',
                    'Job applications must stay associated with the exact public job URL and slug.',
                    'No private ATS, candidate, salary, fee or client data is exposed by this action map.',
                ],
            ]);
    }

    public function factsJson()
    {
        $facts = config('BrandFacts');
        if (!$facts) {
            return $this->response->setStatusCode(404)->setJSON(['error' => 'Canonical brand facts are not available.']);
        }

        return $this->response
            ->setHeader('Cache-Control', 'public, max-age=3600')
            ->setJSON([
                'name' => 'HiredNext Canonical Public Facts',
                'status' => 'source_of_record_for_site_consistency',
                'facts' => $facts->facts,
                'numeric_claim_policy' => $facts->numericClaimPolicy,
                'numeric_claims_not_currently_canonical' => $facts->unverifiedNumericClaims,
                'related_sources' => [
                    'founder_profile' => base_url('about/taru-shikha'),
                    'company_media' => base_url('authority/media.json'),
                    'hiring_intelligence' => base_url('authority/hiring-intelligence.json'),
                    'placement_evidence' => base_url('authority/placement-evidence.json'),
                    'public_actions' => base_url('authority/actions.json'),
                ],
            ]);
    }
}
