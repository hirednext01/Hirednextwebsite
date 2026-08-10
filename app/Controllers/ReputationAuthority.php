<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ReputationAuthority extends BaseController
{
    public function testimonials()
    {
        $settings = $this->loadWebsiteSettings();
        $db = \Config\Database::connect();
        $items = [];

        if ($db->tableExists('reviews')) {
            $builder = $db->table('reviews')
                ->groupStart()
                    ->where('status', 'active')
                    ->orWhere('status', 'external')
                ->groupEnd()
                ->orderBy('sort_order', 'ASC')
                ->orderBy('created_at', 'DESC');
            $items = $builder->get()->getResultArray();
        }

        $items = $this->deduplicateTestimonials($items);

        $sourceItems = [];
        foreach ($items as $item) {
            $sourceUrl = trim((string)($item['source_url'] ?? ''));
            if ($sourceUrl === '') {
                continue;
            }

            $sourceItems[] = [
                '@type' => 'ListItem',
                'position' => count($sourceItems) + 1,
                'item' => [
                    '@type' => 'WebPage',
                    'url' => $sourceUrl,
                    'name' => trim((string)($item['client_name'] ?? $item['name'] ?? 'External recommendation')) . ' — ' . trim((string)($item['proof_type'] ?? $item['project_type'] ?? 'Recruitment recommendation')),
                    'about' => [
                        ['@id' => 'https://hirednext.net/#organization'],
                        ['@id' => base_url('about/taru-shikha') . '#person'],
                    ],
                ],
            ];
        }

        $pageUrl = base_url('testimonials');
        $jsonLd = [
            '@context' => 'https://schema.org',
            '@graph' => [
                [
                    '@type' => 'CollectionPage',
                    '@id' => $pageUrl . '#collection',
                    'url' => $pageUrl,
                    'name' => 'HiredNext Recruitment Testimonials and External Recommendations',
                    'description' => 'Source-linked external recommendations and recruitment feedback connected to HiredNext Recruitment and founder Taru Shikha.',
                    'about' => [
                        ['@id' => 'https://hirednext.net/#organization'],
                        ['@id' => base_url('about/taru-shikha') . '#person'],
                    ],
                    'inLanguage' => 'en-IN',
                    'mainEntity' => [
                        '@type' => 'ItemList',
                        'numberOfItems' => count($sourceItems),
                        'itemListElement' => $sourceItems,
                    ],
                ],
                [
                    '@type' => 'BreadcrumbList',
                    'itemListElement' => [
                        ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => base_url('/')],
                        ['@type' => 'ListItem', 'position' => 2, 'name' => 'Testimonials', 'item' => $pageUrl],
                    ],
                ],
            ],
        ];

        return view('pages/testimonials', [
            'title' => 'Recruitment Testimonials & LinkedIn Recommendations | HiredNext',
            'metaDescription' => 'Public LinkedIn recommendations, recruitment partnership endorsements and feedback connected to HiredNext Recruitment and founder Taru Shikha.',
            'metaKeywords' => 'HiredNext reviews, HiredNext testimonials, Taru Shikha recommendations, recruitment company reviews India, executive search testimonials, leadership hiring India',
            'canonical' => $pageUrl,
            'currentPage' => 'testimonials',
            'settings' => $settings,
            'testimonials' => $items,
            'jsonLd' => json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT),
        ]);
    }

    public function share()
    {
        return view('pages/testimonial-share', [
            'title' => 'Share Your HiredNext Story | Candidate Testimonial',
            'metaDescription' => 'Share how HiredNext supported your job search, hiring journey or career progress. Candidate stories are reviewed before publication.',
            'canonical' => base_url('testimonials/share'),
            'currentPage' => 'testimonials',
            'settings' => $this->loadWebsiteSettings(),
        ]);
    }

    public function submit()
    {
        $name = trim((string)$this->request->getPost('name'));
        $email = trim((string)$this->request->getPost('email'));
        $phone = trim((string)$this->request->getPost('phone'));
        $currentRole = trim((string)$this->request->getPost('current_role'));
        $helpReceived = trim((string)$this->request->getPost('help_received'));
        $story = trim((string)$this->request->getPost('story'));
        $linkedinUrl = trim((string)$this->request->getPost('linkedin_url'));
        $futureSupport = trim((string)$this->request->getPost('future_support'));
        $consent = $this->request->getPost('publish_consent') === '1';

        $errors = [];
        if (mb_strlen($name) < 2) {
            $errors[] = 'Please enter your name.';
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Please enter a valid email address.';
        }
        if ($helpReceived === '') {
            $errors[] = 'Please tell us how HiredNext helped you.';
        }
        if (mb_strlen($story) < 30) {
            $errors[] = 'Please share a little more about your journey (at least 30 characters).';
        }
        if (!in_array($futureSupport, ['yes', 'maybe', 'no'], true)) {
            $errors[] = 'Please tell us whether you would like HiredNext support in future.';
        }
        if (!$consent) {
            $errors[] = 'Please confirm that HiredNext may review and publish your testimonial.';
        }
        if ($linkedinUrl !== '') {
            $validUrl = filter_var($linkedinUrl, FILTER_VALIDATE_URL);
            $scheme = strtolower((string)parse_url($linkedinUrl, PHP_URL_SCHEME));
            if (!$validUrl || !in_array($scheme, ['http', 'https'], true)) {
                $errors[] = 'Please enter a valid LinkedIn or public proof URL.';
            }
        }

        if ($errors) {
            return redirect()->back()->withInput()->with('errors', $errors);
        }

        $db = \Config\Database::connect();
        if (!$db->tableExists('reviews')) {
            return redirect()->back()->withInput()->with('errors', ['Testimonial submissions are temporarily unavailable.']);
        }

        $now = date('Y-m-d H:i:s');
        $data = [
            'client_name' => $name,
            'name' => $name,
            'comment' => $story,
            'rating' => 0,
            'project_type' => 'Candidate Journey',
            'location' => $currentRole ?: null,
            'proof_type' => 'Candidate Story',
            'source_label' => null,
            'source_url' => null,
            'linkedin_url' => $linkedinUrl ?: null,
            'submitter_email' => $email,
            'submitter_phone' => $phone ?: null,
            'help_received' => $helpReceived,
            'future_support' => $futureSupport,
            'publish_consent' => 1,
            'submitted_via' => 'candidate_testimonial_form',
            'status' => 'pending',
            'sort_order' => 0,
            'created_at' => $now,
            'updated_at' => $now,
        ];

        try {
            $db->table('reviews')->insert($data);
            $submissionId = $db->insertID();
        } catch (\Throwable $e) {
            log_message('error', 'Candidate testimonial submission failed: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('errors', ['We could not save your testimonial right now. Please try again shortly.']);
        }

        try {
            $emailService = \Config\Services::email();
            $emailService->setTo('tarushikha@hirednext.info');
            $emailService->setSubject('New candidate testimonial submission #' . $submissionId);
            $emailService->setMessage(
                "A new candidate testimonial is awaiting review.\n\n" .
                "Name: {$name}\n" .
                "Email: {$email}\n" .
                "Phone: {$phone}\n" .
                "Current role: {$currentRole}\n" .
                "How HiredNext helped: {$helpReceived}\n" .
                "Future support: {$futureSupport}\n" .
                "LinkedIn/public identity: {$linkedinUrl}\n\n" .
                "Story:\n{$story}\n\n" .
                "Status: pending review\n"
            );
            if (!$emailService->send()) {
                log_message('error', 'Candidate testimonial notification email failed for submission #' . $submissionId);
            }
        } catch (\Throwable $e) {
            log_message('error', 'Candidate testimonial email error: ' . $e->getMessage());
        }

        return redirect()->to('/testimonials/share?submitted=1')
            ->with('success', 'Thank you. Your story has been received and will be reviewed before anything is published.');
    }

    private function deduplicateTestimonials(array $items): array
    {
        $unique = [];
        $seen = [];

        foreach ($items as $item) {
            $sourceUrl = $this->normalizeSourceUrl((string)($item['source_url'] ?? ''));
            $name = $this->normalizeProofText((string)($item['client_name'] ?? $item['name'] ?? ''));
            $quote = $this->normalizeProofText((string)($item['comment'] ?? $item['review'] ?? $item['review_text'] ?? $item['content'] ?? $item['testimonial'] ?? $item['message'] ?? ''));

            $keys = [];
            if ($sourceUrl !== '') {
                $keys[] = 'source:' . $sourceUrl;
            }
            if ($name !== '' && $quote !== '') {
                $keys[] = 'content:' . hash('sha256', $name . '|' . $quote);
            }

            $existingIndex = null;
            foreach ($keys as $key) {
                if (isset($seen[$key])) {
                    $existingIndex = $seen[$key];
                    break;
                }
            }

            if ($existingIndex === null) {
                $existingIndex = count($unique);
                $unique[] = $item;
                foreach ($keys as $key) {
                    $seen[$key] = $existingIndex;
                }
                continue;
            }

            if ($this->testimonialProofScore($item) > $this->testimonialProofScore($unique[$existingIndex])) {
                $unique[$existingIndex] = $item;
            }

            foreach ($keys as $key) {
                $seen[$key] = $existingIndex;
            }
        }

        return array_values($unique);
    }

    private function testimonialProofScore(array $item): int
    {
        $score = 0;
        if (trim((string)($item['source_url'] ?? '')) !== '') {
            $score += 8;
        }
        if (($item['status'] ?? '') === 'external') {
            $score += 4;
        }
        if (trim((string)($item['location'] ?? $item['designation'] ?? '')) !== '') {
            $score += 2;
        }
        if (trim((string)($item['linkedin_url'] ?? '')) !== '') {
            $score += 1;
        }
        return $score;
    }

    private function normalizeSourceUrl(string $value): string
    {
        $value = strtolower(trim($value));
        if ($value === '') {
            return '';
        }
        $value = preg_replace('/[?#].*$/', '', $value) ?? $value;
        return rtrim($value, '/');
    }

    private function normalizeProofText(string $value): string
    {
        $value = mb_strtolower(trim(strip_tags($value)));
        return preg_replace('/\s+/u', ' ', $value) ?? $value;
    }
}
