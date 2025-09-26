<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Base path for Posts module
$routes->group('files', ['namespace' => 'App\Modules\Files\Controllers'], function($routes) {

    // List all posts
    $routes->get('/', 'files::index');

});
