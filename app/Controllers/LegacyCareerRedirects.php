<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class LegacyCareerRedirects extends BaseController
{
    public function cvAssessment()
    {
        $target = base_url('services/cv-assessment');
        $query = $this->request->getGet();
        if (!empty($query)) {
            $target .= '?' . http_build_query($query);
        }

        return redirect()->to($target, 301);
    }

    public function avron()
    {
        return redirect()->to(base_url('services/professional-cv-rebuild'), 301);
    }
}
