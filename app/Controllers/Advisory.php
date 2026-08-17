<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Advisory extends BaseController
{
    public function gateway()
    {
        return view('pages/speak-to-hirednext', [
            'title' => 'Speak to HiredNext | Hiring, Jobs & Strategic Advisory',
            'metaDescription' => 'Choose the right HiredNext route for a hiring mandate, career strategy, CXO strategic advisory or current job opportunities.',
            'canonical' => base_url('speak-to-hirednext'),
            'currentPage' => 'contact',
            'settings' => $this->loadWebsiteSettings(),
        ]);
    }

    public function hiringDiscussion()
    {
        return view('pages/hiring-discussion', [
            'title' => 'Discuss a Hiring Mandate | HiredNext Recruitment',
            'metaDescription' => 'Share your active or upcoming hiring requirement with HiredNext before scheduling a recruitment discussion.',
            'canonical' => base_url('hiring-discussion'),
            'currentPage' => 'contact',
            'settings' => $this->loadWebsiteSettings(),
        ]);
    }

    public function index()
    {
        return view('pages/advisory', [
            'title' => 'Career Strategy & CXO Strategic Advisory | HiredNext',
            'metaDescription' => 'Limited researched career strategy and confidential CXO advisory appointments from HiredNext for experienced professionals and senior leaders.',
            'canonical' => base_url('advisory'),
            'currentPage' => 'advisory',
            'settings' => $this->loadWebsiteSettings(),
        ]);
    }
}
