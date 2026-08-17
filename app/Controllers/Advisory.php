<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Advisory extends BaseController
{
    public function index()
    {
        return view('pages/advisory', [
            'title' => 'Strategic Advisory | HiredNext',
            'metaDescription' => 'Limited strategic consultation and CXO advisory appointments from HiredNext for experienced professionals and senior leaders.',
            'canonical' => base_url('advisory'),
            'currentPage' => 'advisory',
            'settings' => $this->loadWebsiteSettings(),
        ]);
    }
}
