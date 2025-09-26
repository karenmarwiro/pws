<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


// Authentication routes
service('auth')->routes($routes);
$routes->get('auth/redirect/github', 'GithubAuthController::redirect');
$routes->get('auth/callback/github', 'GithubAuthController::callback');

$routes->group('auth', ['namespace' => 'App\Controllers'], static function ($routes) {
    $routes->get('login', 'LoginController::loginView');
    $routes->post('login', 'LoginController::loginAction');
    $routes->get('logout', 'LoginController::logoutAction');
});

// Load Core routes
require APPPATH . 'Core/Config/Routes.php';

// Autoload module routes
$modulesPath = APPPATH . 'Modules/';
$modules = array_diff(scandir($modulesPath), ['.', '..','...', '.DS_Store']);

foreach ($modules as $module) {
    $modulePath = $modulesPath . $module;
    if (is_dir($modulePath)) {
        $routesFile = $modulePath . '/Config/Routes.php';
        if (file_exists($routesFile)) {
            require $routesFile;
        }
    }
}




