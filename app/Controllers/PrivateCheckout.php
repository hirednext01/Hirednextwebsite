<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class PrivateCheckout extends BaseController
{
    private const TOKEN = 'd3e28e9c85069585175d8b4ead1f0b1ee2dea44006b18a8f';

    public function linkedinLeadership(string $token)
    {
        if (!hash_equals(self::TOKEN, strtolower($token))) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $html = view('pages/services/linkedin-leadership-payment', [
            'title' => 'Private LinkedIn Leadership Positioning Payment | HiredNext',
            'metaDescription' => 'Private HiredNext professional-service payment page.',
            'canonical' => base_url('services/candidates'),
            'currentPage' => 'services',
            'settings' => $this->loadWebsiteSettings(),
        ]);

        return $this->response
            ->setHeader('X-Robots-Tag', 'noindex, nofollow, noarchive')
            ->setHeader('Cache-Control', 'no-store, private, max-age=0')
            ->setHeader('Pragma', 'no-cache')
            ->setBody($html);
    }
}
