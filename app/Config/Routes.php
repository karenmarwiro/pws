<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
service('auth')->routes($routes);
$routes->get('auth/redirect/github', 'GithubAuthController::redirect');
$routes->get('auth/callback/github', 'GithubAuthController::callback');


// Admin routes
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function($routes) {
    // Authentication routes
    $routes->get('login', 'Auth::login', ['as' => 'admin.login']);
    $routes->post('login', 'Auth::login');
    $routes->get('logout', 'Auth::logout', ['as' => 'admin.logout']);
    
    // Protected admin routes
    $routes->group('', ['filter' => 'session'], function($routes) {
        $routes->get('dashboard', 'Auth::dashboard', ['as' => 'admin.dashboard']);
        // Add more protected admin routes here
    });
});