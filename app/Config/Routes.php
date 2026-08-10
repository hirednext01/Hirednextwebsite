<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Main website routes
$routes->get('/', 'Home::index');
$routes->get('about', 'Home::about');
$routes->get('services', 'CandidateServices::services');
$routes->get('services/clients', 'CandidateServices::clientServices');
$routes->get('services/candidates', 'CandidateServices::candidateServices');
$routes->get('services/cv-assessment', 'CandidateServices::cvAssessment');
$routes->get('services/(:any)', 'Home::serviceDetail/$1');
// Backward-compatible alias so existing job links/bookmarks continue to work.
$routes->get('cv-assessment', 'CandidateServices::cvAssessment');
$routes->post('cv-assessment/submit', 'CvAssessment::submit');
$routes->get('cv-payment/(:num)', 'CvPayment::checkout/$1');
$routes->post('cv-payment/verify', 'CvPayment::verify');
$routes->get('robots.txt', 'Seo::robots');
$routes->get('sitemap.xml', 'Seo::sitemap');
$routes->get('insights', 'Aeo::index');
$routes->get('insights/(:any)', 'Aeo::show/$1');
$routes->get('industry/(:any)', 'Home::industry/$1');
$routes->get('regions/(:any)', 'Home::region/$1');
$routes->get('blog', 'Home::blog');
$routes->get('blog/(:any)', 'Home::blogPost/$1');
$routes->get('press-media', 'Home::pressMedia');
$routes->get('contact', 'Home::contact');
$routes->get('jobs', 'Jobs::index');
$routes->get('jobs/(:any)', 'Home::jobDetail/$1');
$routes->post('jobs/(:any)/apply', 'Home::applyJob/$1');
$routes->get('testimonials', 'Home::testimonials');
$routes->post('contact/submit', 'Home::submitContact');
$routes->get('test', 'Test::index');

// API Routes for React Admin Panel
$routes->group('api', ['namespace' => 'App\\Controllers\\Api'], function ($routes) {
    $routes->options('(:any)', function () { return service('response')->setStatusCode(200); });
    $routes->get('test', 'TestApi::index'); $routes->get('test/auth', 'TestApi::testAuth');
    $routes->post('auth/login', 'AuthApi::login'); $routes->post('auth/logout', 'AuthApi::logout'); $routes->get('auth/me', 'AuthApi::me'); $routes->post('auth/change-password', 'AuthApi::changePassword');
    $routes->get('users', 'UsersApi::index'); $routes->get('users/(:num)', 'UsersApi::show/$1'); $routes->post('users', 'UsersApi::create'); $routes->put('users/(:num)', 'UsersApi::update/$1'); $routes->delete('users/(:num)', 'UsersApi::delete/$1'); $routes->put('users/(:num)/status', 'UsersApi::changeStatus/$1'); $routes->post('users/(:num)/change-password', 'UsersApi::changePassword/$1'); $routes->post('users/(:num)/reset-password', 'UsersApi::resetPassword/$1'); $routes->get('profile', 'UsersApi::profile'); $routes->put('profile', 'UsersApi::updateProfile');
    $routes->get('settings', 'SettingsApi::index'); $routes->get('settings/(:any)', 'SettingsApi::show/$1'); $routes->put('settings', 'SettingsApi::update');
    $routes->get('services', 'ServicesApi::index'); $routes->get('services/(:num)', 'ServicesApi::show/$1'); $routes->post('services', 'ServicesApi::create'); $routes->put('services/(:num)', 'ServicesApi::update/$1'); $routes->delete('services/(:num)', 'ServicesApi::delete/$1');
    $routes->get('team', 'TeamApi::index'); $routes->get('team/(:num)', 'TeamApi::show/$1'); $routes->post('team', 'TeamApi::create'); $routes->put('team/(:num)', 'TeamApi::update/$1'); $routes->delete('team/(:num)', 'TeamApi::delete/$1'); $routes->post('team/upload-image', 'TeamApi::uploadImage');
    $routes->get('products', 'ProductsApi::index'); $routes->get('products/(:num)', 'ProductsApi::show/$1'); $routes->post('products', 'ProductsApi::create'); $routes->put('products/(:num)', 'ProductsApi::update/$1'); $routes->delete('products/(:num)', 'ProductsApi::delete/$1');
    $routes->get('clients', 'ClientsApi::index'); $routes->get('clients/(:num)', 'ClientsApi::show/$1'); $routes->post('clients', 'ClientsApi::create'); $routes->put('clients/(:num)', 'ClientsApi::update/$1'); $routes->delete('clients/(:num)', 'ClientsApi::delete/$1');
    $routes->get('reviews', 'ReviewsApi::index'); $routes->get('reviews/(:num)', 'ReviewsApi::show/$1'); $routes->post('reviews', 'ReviewsApi::create'); $routes->put('reviews/(:num)', 'ReviewsApi::update/$1'); $routes->delete('reviews/(:num)', 'ReviewsApi::delete/$1');
    $routes->get('achievements', 'AchievementsApi::index'); $routes->get('achievements/(:num)', 'AchievementsApi::show/$1'); $routes->post('achievements', 'AchievementsApi::create'); $routes->put('achievements/(:num)', 'AchievementsApi::update/$1'); $routes->delete('achievements/(:num)', 'AchievementsApi::delete/$1');
    $routes->get('industries', 'IndustriesApi::index'); $routes->get('industries/(:num)', 'IndustriesApi::show/$1'); $routes->post('industries', 'IndustriesApi::create'); $routes->put('industries/(:num)', 'IndustriesApi::update/$1'); $routes->delete('industries/(:num)', 'IndustriesApi::delete/$1');
    $routes->get('partners', 'PartnersApi::index'); $routes->get('partners/(:num)', 'PartnersApi::show/$1'); $routes->post('partners', 'PartnersApi::create'); $routes->put('partners/(:num)', 'PartnersApi::update/$1'); $routes->delete('partners/(:num)', 'PartnersApi::delete/$1');
    $routes->get('blog', 'BlogApi::index'); $routes->get('blog/(:num)', 'BlogApi::show/$1'); $routes->post('blog', 'BlogApi::create'); $routes->put('blog/(:num)', 'BlogApi::update/$1'); $routes->delete('blog/(:num)', 'BlogApi::delete/$1');
    $routes->get('aeo-insights', 'AeoInsightsApi::index'); $routes->get('aeo-insights/(:num)', 'AeoInsightsApi::show/$1'); $routes->post('aeo-insights', 'AeoInsightsApi::create'); $routes->put('aeo-insights/(:num)', 'AeoInsightsApi::update/$1'); $routes->delete('aeo-insights/(:num)', 'AeoInsightsApi::delete/$1');
    $routes->post('contact/submit', 'ContactApi::submit'); $routes->get('contact/leads', 'ContactApi::index'); $routes->get('contact/leads/(:num)', 'ContactApi::show/$1'); $routes->put('contact/leads/(:num)', 'ContactApi::update/$1'); $routes->delete('contact/leads/(:num)', 'ContactApi::delete/$1');
    $routes->post('upload', 'UploadController::index'); $routes->delete('upload/(:any)', 'UploadController::delete/$1');
    $routes->get('contact-messages', 'ContactMessagesApi::index'); $routes->get('contact-messages/(:num)', 'ContactMessagesApi::show/$1'); $routes->post('contact-messages', 'ContactMessagesApi::create'); $routes->put('contact-messages/(:num)/read', 'ContactMessagesApi::markAsRead/$1'); $routes->put('contact-messages/(:num)/replied', 'ContactMessagesApi::markAsReplied/$1'); $routes->put('contact-messages/(:num)/archived', 'ContactMessagesApi::markAsArchived/$1'); $routes->delete('contact-messages/(:num)', 'ContactMessagesApi::delete/$1'); $routes->get('contact-messages/stats', 'ContactMessagesApi::getStats');
    $routes->get('projects', 'ProjectsApi::index'); $routes->get('projects/(:num)', 'ProjectsApi::show/$1'); $routes->post('projects', 'ProjectsApi::create'); $routes->put('projects/(:num)', 'ProjectsApi::update/$1'); $routes->delete('projects/(:num)', 'ProjectsApi::delete/$1'); $routes->post('projects/upload', 'ProjectsApi::uploadImage');
    $routes->get('jobs', 'JobsApi::index'); $routes->post('jobs', 'JobsApi::create'); $routes->get('jobs/departments', 'JobsApi::departments'); $routes->get('jobs/(:num)', 'JobsApi::show/$1'); $routes->put('jobs/(:num)', 'JobsApi::update/$1'); $routes->delete('jobs/(:num)', 'JobsApi::delete/$1'); $routes->get('jobs/(:num)/applications', 'JobsApi::applications/$1'); $routes->put('applications/(:num)', 'JobApplicationsApi::update/$1');
    $routes->get('press-media', 'PressMediaApi::index'); $routes->get('press-media/(:num)', 'PressMediaApi::show/$1'); $routes->post('press-media', 'PressMediaApi::create'); $routes->put('press-media/(:num)', 'PressMediaApi::update/$1'); $routes->delete('press-media/(:num)', 'PressMediaApi::delete/$1');
});
