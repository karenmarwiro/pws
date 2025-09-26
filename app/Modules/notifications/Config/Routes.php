<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Base path for comments module
$routes->group('notifications', ['namespace' => 'App\Modules\Notifications\Controllers'], function($routes) {

    
    $routes->get('/', 'notifications::index');

});
