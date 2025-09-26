<?php

namespace app\Core\Config;

use CodeIgniter\Config\BaseConfig;
use Config\Services;

$routes = Services::routes();

// Set the default namespace for all routes
$routes->setDefaultNamespace('App\Core\Controllers');

$routes->get('/', 'AdminController::dashboard');
$routes->get('/dashboard', 'AdminController::dashboard');

$routes->get('modules', 'Modules::index');
$routes->get('modules/add', 'Modules::add');
$routes->get('modules/edit/(:num)', 'Modules::edit/$1');
// Module deletion
$routes->post('modules/delete/(:num)', 'Modules::delete/$1');
$routes->post('modules/upload', 'Modules::upload');

//settings Routes
$routes->group('settings', ['namespace' => 'App\Core\Controllers'], function($routes){
    $routes->get('', 'Settings::index');
    $routes->post('save', 'Settings::save');
    });


// API Routes
$routes->group('api', ['namespace' => 'App\Core\Controllers'], function($routes) {
    $routes->post('modules/(:num)/toggle', 'Modules::toggle/$1', ['namespace' => 'App\Core\Controllers']);
});

//  rbac group below
$routes->group('rbac', ['namespace' => 'App\Core\Controllers'], function($routes){
    // Roles home
    $routes->get('', 'RBAC::index');
    $routes->get('roles', 'RBAC::index'); // Alias for the index pag
    // Role CRUD
    $routes->get('roles/add', 'RBAC::createRole');
    $routes->post('roles/add', 'RBAC::addRole');
    $routes->get('roles/edit/(:num)', 'RBAC::editRole/$1');
    $routes->post('roles/update/(:num)', 'RBAC::updateRole/$1');
    $routes->post('roles/delete/(:num)', 'RBAC::deleteRole/$1');
    // Show form
    $routes->get('roles/assign/(:num)', 'RBAC::showAssignRoleForm/$1');
    // Handle POST submission
    $routes->post('roles/assign/(:num)', 'RBAC::assignRoleToUser/$1');
    $routes->post('roles/remove/(:num)', 'RBAC::removeRoleFromUser/$1');

    // Permissions index & CRUD
    $routes->get('permissions', 'RBAC::permissions');
    $routes->get('permissions/add', 'RBAC::addPermission');
    $routes->post('permissions/add', 'RBAC::addPermission');
    $routes->get('permissions/edit/(:num)', 'RBAC::editPermission/$1');
    $routes->post('permissions/edit/(:num)', 'RBAC::editPermission/$1');
    $routes->post('permissions/delete/(:num)', 'RBAC::deletePermission/$1');

    // Role ↔ Permissions
    $routes->get('roles/permissions/(:num)', 'RBAC::rolePermissions/$1');
    $routes->post('roles/permissions/(:num)', 'RBAC::saveRolePermissions/$1');
});


    // Users management
  $routes->group('rbac/users', ['namespace' => 'App\Core\Controllers'], function($routes) {
    $routes->get('/', 'Users::index');
    $routes->get('view/(:num)', 'Users::view/$1');
    $routes->get('add', 'Users::showAddForm');
    $routes->post('store', 'Users::storeUser');
    $routes->get('edit/(:num)', 'Users::edit/$1');
    $routes->post('update/(:num)', 'Users::update/$1');
    // Roles
    $routes->get('assign-role/(:num)', 'Users::assignRole/$1');
    $routes->post('assign-role/(:num)', 'Users::assignRole/$1');
    $routes->get('remove-role/(:num)/(:segment)', 'Users::removeRole/$1/$2');
    // DELETE route
    $routes->delete('delete/(:num)', 'Users::delete/$1');
});