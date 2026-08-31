<?php

/** @var \CodeIgniter\Router\RouteCollection $routes */

$routes->get('admin/cv-studio', 'CvStudioAdmin::index');
$routes->get('admin/cv-studio/(:num)', 'CvStudioAdmin::detail/$1');
$routes->post('admin/cv-studio/(:num)/generate', 'CvStudioAdmin::generate/$1');
$routes->get('admin/cv-studio/(:num)/documents/(:num)', 'CvStudioAdmin::preview/$1/$2');
$routes->get('admin/cv-studio/(:num)/documents/(:num)/word', 'CvStudioDocumentController::downloadWord/$1/$2');
$routes->post('admin/cv-studio/(:num)/documents/(:num)/deliver', 'CvStudioDocumentController::deliver/$1/$2');
$routes->post('admin/cv-studio/(:num)/documents/(:num)/branding', 'CvStudioAdmin::branding/$1/$2');
