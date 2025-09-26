<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('plc', ['namespace' => 'App\Modules\Plc\Controllers'], function ($routes) {
    $routes->get('/', 'Plc::index'); // main management page
    $routes->get('applications', 'Plc::getApplications'); // ajax list of applications
    $routes->get('view/(:num)', 'Plc::view/$1'); // view single app
    $routes->post('update-status/(:num)', 'Plc::updateStatus/$1'); // update status
    $routes->post('delete/(:num)', 'Plc::delete/$1');


  $routes->get('ajax-applications', 'Plc::getApplicationsByStatus');


});
