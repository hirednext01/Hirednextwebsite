<?php

namespace App\Controllers;

use App\Models\WebsiteSettingsModel;
use App\Models\ServicesModel;
use App\Models\TeamModel;
use App\Models\ProductsModel;
use App\Models\ClientsModel;
use App\Models\ReviewsModel;
use App\Models\AchievementsModel;

class Test extends BaseController
{
    public function index()
    {
        try {
            $settingsModel = new WebsiteSettingsModel();
            $servicesModel = new ServicesModel();
            $teamModel = new TeamModel();
            $productsModel = new ProductsModel();
            $clientsModel = new ClientsModel();
            $reviewsModel = new ReviewsModel();
            $achievementsModel = new AchievementsModel();

            $data = [
                'database_status' => 'Connected',
                'settings_count' => count($settingsModel->getAllSettings()),
                'services_count' => count($servicesModel->getActiveServices()),
                'team_count' => count($teamModel->getActiveTeam()),
                'products_count' => count($productsModel->getActiveProducts()),
                'clients_count' => count($clientsModel->getActiveClients()),
                'reviews_count' => count($reviewsModel->getActiveReviews()),
                'achievements_count' => count($achievementsModel->getActiveAchievements()),
                'sample_settings' => $settingsModel->getAllSettings(),
                'sample_services' => array_slice($servicesModel->getActiveServices(), 0, 3),
                'sample_products' => array_slice($productsModel->getActiveProducts(), 0, 3),
            ];

            return $this->response->setJSON($data);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'error' => $e->getMessage(),
                'database_status' => 'Error'
            ]);
        }
    }
}
