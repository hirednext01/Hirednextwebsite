<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// Main website routes
$routes->get('/', 'Home::index');
$routes->get('about', 'Home::about');
$routes->get('about/taru-shikha', 'Authority::founder');
$routes->get('services', 'CandidateServices::services');
$routes->get('services/clients', 'CandidateServices::clientServices');
$routes->get('services/candidates', 'CandidateServices::candidateServices');
$routes->get('services/cv-assessment', 'CandidateServices::cvAssessment');
$routes->get('career-services/start/(:segment)', 'CvServiceCheckout::start/$1');
$routes->post('career-services/start/(:segment)', 'CvServiceCheckout::submit/$1');
// Legacy Avron URL now resolves to HiredNext's current recruiter-led career advisory.
$routes->get('services/avron', 'CandidateServices::candidateServices');
$routes->get('services/(:any)', 'Home::serviceDetail/$1');
$routes->get('speak-to-hirednext', 'Advisory::gateway');
$routes->get('hiring-discussion', 'Advisory::hiringDiscussion');
$routes->post('hiring-discussion/submit', 'Advisory::submitHiringDiscussion');
$routes->get('advisory', 'Advisory::index');
$routes->get('advisory/payment/(:segment)', 'Advisory::payment/$1');
$routes->post('advisory/payment/submit', 'Advisory::submitAdvisoryPayment');
$routes->get('cv-assessment', 'CandidateServices::cvAssessment');
$routes->post('cv-assessment/submit', 'CvAssessment::submit');
$routes->get('cv-payment/qr', 'CvPayment::qr');
$routes->get('cv-payment/(:num)', 'CvPayment::checkout/$1');
$routes->post('cv-payment/verify', 'CvPayment::verify');

// Secure candidate checkout links created from the CV Reviews admin.
$routes->get('cv-upgrade/(:segment)', 'CvUpgrade::checkout/$1');
$routes->post('cv-upgrade/(:segment)', 'CvUpgrade::submit/$1');

// Existing website-admin credentials protect this CV-review module.
$routes->get('admin/cv-reviews', 'CvReviewAdmin::index');
$routes->post('admin/cv-reviews/login', 'CvReviewAdmin::login');
$routes->get('admin/cv-reviews/logout', 'CvReviewAdmin::logout');
$routes->get('admin/cv-reviews/(:num)/resume', 'CvReviewAdmin::resume/$1');
$routes->get('admin/cv-reviews/(:num)/report', 'CvReviewAdmin::printReport/$1');
$routes->post('admin/cv-reviews/(:num)/analyse', 'CvReviewAdmin::analyse/$1');
$routes->post('admin/cv-reviews/(:num)/payment-verified', 'CvReviewAdmin::markPaymentVerified/$1');
$routes->post('admin/cv-reviews/(:num)/report/save', 'CvReviewAdmin::saveReport/$1');
$routes->post('admin/cv-reviews/(:num)/report/approve', 'CvReviewAdmin::approveReport/$1');
$routes->post('admin/cv-reviews/(:num)/report/send', 'CvReviewAdmin::sendReport/$1');
$routes->post('admin/cv-reviews/(:num)/offer/(:segment)', 'CvReviewAdmin::offer/$1/$2');
$routes->post('admin/cv-reviews/(:num)/orders/(:num)/verify', 'CvReviewAdmin::verifyUpgrade/$1/$2');
$routes->post('admin/cv-reviews/(:num)/orders/(:num)/status', 'CvReviewAdmin::updateUpgradeStatus/$1/$2');
$routes->post('admin/cv-reviews/(:num)/status', 'CvReviewAdmin::updateStatus/$1');
$routes->get('admin/cv-reviews/(:num)', 'CvReviewAdmin::detail/$1');

$routes->get('robots.txt', 'Seo::robots');
$routes->get('sitemap.xml', 'Seo::sitemap');
$routes->get('llms.txt', 'Seo::llms');
$routes->get('authority/entity.json', 'EntityAuthority::entityJson');
$routes->get('authority/media.json', 'Authority::mediaJson');
$routes->get('authority/placement-evidence.json', 'Authority::placementEvidenceJson');
$routes->get('mandate-stories', 'MandateStories::index');
$routes->get('authority/mandate-evidence.json', 'MandateStories::evidenceJson');
$routes->get('hiring-intelligence', 'DiscoveryAuthority::hiringIntelligence');
$routes->get('authority/hiring-intelligence.json', 'DiscoveryAuthority::hiringIntelligenceJson');
$routes->get('authority/actions.json', 'DiscoveryAuthority::actionsJson');
$routes->get('authority/facts.json', 'DiscoveryAuthority::factsJson');
$routes->get('authority/recommendation-evidence.json', 'DecisionGuides::recommendationEvidenceJson');
$routes->get('authority/search-pages.json', 'SearchAuthority::discoveryJson');
$routes->get('top-recruitment-company-india', 'DecisionGuides::topRecruitmentCompany');
$routes->get('guides/executive-search-firm-india', 'DecisionGuides::legacyExecutiveSearchGuide');
$routes->get('guides/(:segment)', 'DecisionGuides::show/$1');
$routes->get('insights', 'Aeo::index');
$routes->get('insights/(:any)', 'Aeo::show/$1');

$routes->get('industry/garment-textile-recruitment-india', 'IndustryAuthority::garmentTextile');
$routes->get('industry/it-recruitment-services-india', 'IndustryAuthority::itTechnology');
$routes->get('industry/bfsi-leadership-hiring', 'IndustryAuthority::bfsiNbfc');
$routes->get('industry/pharma-life-sciences-recruitment-india', 'IndustryAuthority::pharmaLifeSciences');
$routes->get('industry/global-capability-centres-hiring-india', 'IndustryAuthority::globalCapabilityCentres');
$routes->get('industry/semiconductor-recruitment-india', 'IndustryAuthority::semiconductors');
$routes->get('industry/manufacturing-recruitment-india', 'SearchAuthority::show/manufacturing-recruitment-india');
$routes->get('industry/(:any)', 'Home::industry/$1');

$routes->get('regions/executive-search-bangalore', 'SearchAuthority::show/executive-search-bangalore');
$routes->get('regions/executive-search-gurgaon', 'SearchAuthority::show/executive-search-gurgaon');
$routes->get('regions/executive-search-mumbai', 'SearchAuthority::show/executive-search-mumbai');
$routes->get('regions/executive-search-chennai', 'SearchAuthority::show/executive-search-chennai');
$routes->get('regions/(:any)', 'Home::region/$1');
$routes->get('blog', 'Home::blog');
$routes->get('blog/feed.xml', 'Seo::blogFeed');
$routes->get('blog/(:any)', 'Home::blogPost/$1');
$routes->get('press-media', 'Authority::pressMedia');
$routes->get('contact', 'Home::contact');
$routes->get('jobs', 'Jobs::index');
$routes->get('candidate-resume', 'Home::candidateResume');
$routes->get('jobs/(:any)', 'Home::jobDetail/$1');
$routes->post('jobs/(:any)/apply', 'Home::applyJob/$1');
$routes->get('testimonials', 'ReputationAuthority::testimonials');
$routes->get('testimonials/share', 'ReputationAuthority::share');
$routes->post('testimonials/share', 'ReputationAuthority::submit');
$routes->post('contact/submit', 'Home::submitContact');
$routes->get('test', 'Test::index');

// Slack Events API -> HiredNext Revenue Council -> Lyzr -> Slack thread.
$routes->post('webhooks/slack/revenue-council', 'Api\\RevenueCouncilWebhook::handle');

$routes->group('api', ['namespace' => 'App\\Controllers\\Api'], function ($routes) {
    $routes->options('(:any)', function () { return service('response')->setStatusCode(200); });
    $routes->get('test', 'TestApi::index'); $routes->get('test/auth', 'TestApi::testAuth');
    $routes->post('auth/login', 'AuthApi::login'); $routes->post('auth/logout', 'AuthApi::logout'); $routes->get('auth/me', 'AuthApi::me'); $routes->post('auth/change-password', 'AuthApi::changePassword');
    $routes->get('users', 'UsersApi::index'); $routes->get('users/(:num)', 'UsersApi::show/$1'); $routes->post('users', 'UsersApi::create'); $routes->put('users/(:num)', 'UsersApi::update/$1'); $routes->delete('users/(:num)', 'UsersApi::delete/$1'); $routes->put('users/(:num)/status', 'UsersApi::changeStatus/$1'); $routes->post('users/(:num)/change-password', 'UsersApi::changePassword/$1'); $routes->get('profile', 'UsersApi::profile'); $routes->put('profile', 'UsersApi::updateProfile');
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
    $routes->get('projects', 'ProjectsApi::index'); $routes->post('projects', 'ProjectsApi::create'); $routes->get('projects/(:num)', 'ProjectsApi::show/$1'); $routes->put('projects/(:num)', 'ProjectsApi::update/$1'); $routes->delete('projects/(:num)', 'ProjectsApi::delete/$1'); $routes->post('projects/upload', 'ProjectsApi::uploadImage');
    $routes->get('jobs', 'JobsApi::index'); $routes->post('jobs', 'JobsApi::create'); $routes->get('jobs/departments', 'JobsApi::departments'); $routes->get('jobs/(:num)', 'JobsApi::show/$1'); $routes->put('jobs/(:num)', 'JobsApi::update/$1'); $routes->delete('jobs/(:num)', 'JobsApi::delete/$1'); $routes->get('jobs/(:num)/applications', 'JobsApi::applications/$1'); $routes->put('applications/(:num)', 'JobApplicationsApi::update/$1');
    $routes->get('cv-assessments', 'CvAssessmentsApi::index'); $routes->get('cv-assessments/(:num)', 'CvAssessmentsApi::show/$1'); $routes->get('cv-assessments/(:num)/resume', 'CvAssessmentsApi::resume/$1'); $routes->put('cv-assessments/(:num)', 'CvAssessmentsApi::update/$1');
    $routes->get('press-media', 'PressMediaApi::index'); $routes->get('press-media/(:num)', 'PressMediaApi::show/$1'); $routes->post('press-media', 'PressMediaApi::create'); $routes->put('press-media/(:num)', 'PressMediaApi::update/$1'); $routes->delete('press-media/(:num)', 'PressMediaApi::delete/$1');
});