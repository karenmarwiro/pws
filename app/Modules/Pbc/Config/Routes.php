<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->group('pbc', ['namespace' => 'App\Modules\Pbc\Controllers'], function ($routes) {
    $routes->get('/', 'Pbc::index'); // main management page
    $routes->get('applications', 'Pbc::getApplications'); // ajax list of applications
    $routes->get('view/(:num)', 'Pbc::view/$1'); // view single app
    $routes->post('update-status/(:num)', 'Pbc::updateStatus/$1'); // update status
    $routes->post('delete/(:num)', 'Pbc::delete/$1');
    $routes->get('edit/(:num)', 'Pbc::edit/$1');
    $routes->post('update/(:num)', 'Pbc::update/$1');
    $routes->get('shareholder/(:num)', 'Pbc::shareholder/$1');




  $routes->get('ajax-applications', 'Pbc::getApplicationsByStatus');


});
