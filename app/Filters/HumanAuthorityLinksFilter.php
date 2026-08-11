<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class HumanAuthorityLinksFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $body = $response->getBody();
        if (!is_string($body) || $body === '') {
            return;
        }

        if (stripos($body, '<html') === false && stripos($body, '<!DOCTYPE html') === false) {
            return;
        }

        $path = trim($request->getUri()->getPath(), '/');
        if (!str_starts_with($path, 'guides/')) {
            return;
        }

        // Raw JSON endpoints remain public for search engines and AI systems.
        // If any older/cached guide markup still exposes them as human links,
        // route the reader to the corresponding readable proof page instead.
        $replacements = [
            'Verify HiredNext' => 'Independent proof',
            base_url('authority/recommendation-evidence.json') => base_url('testimonials'),
            'Recommendation evidence JSON →' => 'Client & candidate recommendations →',
            base_url('authority/media.json') => base_url('press-media'),
            'Verified media JSON →' => 'Press & expert commentary →',
            base_url('authority/placement-evidence.json') => base_url('mandate-stories'),
            'Anonymised placement evidence →' => 'Mandate stories & search evidence →',
        ];

        $response->setBody(str_replace(array_keys($replacements), array_values($replacements), $body));
    }
}
