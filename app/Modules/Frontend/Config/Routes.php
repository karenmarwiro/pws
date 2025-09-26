<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Public routes
$routes->group('', ['namespace' => 'App\\Modules\\Frontend\\Controllers'], function($routes) {
    $routes->get('/frontend', 'Frontend::index', ['as' => 'home']);
});

// Authenticated routes
$routes->group('', ['namespace' => 'App\\Modules\\Frontend\\Controllers', 'filter' => 'login'], function($routes) {
    // Dashboard and profile
    $routes->get('frontend/dashboard', 'Frontend::dashboard', ['as' => 'frontend.dashboard']);
    $routes->get('frontend/apply', 'Frontend::apply', ['as' => 'apply']);
});

// PBC module routes
$routes->group('frontend', ['namespace' => 'App\Modules\Frontend\Controllers'], static function ($routes) {

    $routes->group('pbc', static function ($routes) {

        // Start application
        $routes->get('start-application', 'PbcController::startApplication');

        // Step 1 - Personal Details
        $routes->get('personal-details', 'PbcController::personalDetails');
        $routes->post('process-personal-details', 'PbcController::processPersonalDetails');

        // Step 2 - Company Details
        $routes->get('company-details', 'PbcController::companyDetails');
        $routes->get('business-details', 'PbcController::businessDetails');
        $routes->post('process-company-details', 'PbcController::processCompanyDetails');

        // Step 3 - Directors & Shareholders
        $routes->get('directors-shareholders', 'PbcController::directorsShareholders');
        $routes->post('process-shareholders', 'PbcController::processShareholders');

        // Step 4 - Review & Submit
        $routes->get('review-submit', 'PbcController::reviewSubmit');
        $routes->post('submit-final', 'PbcController::submitFinalApplication');
        $routes->get('confirmation', 'PbcController::confirmation');
    });
});

//plc routes
$routes->group('frontend', ['namespace' => 'App\Modules\Frontend\Controllers'], static function ($routes) {

    $routes->group('plc', static function ($routes) {

        // Start application
        $routes->get('start-application', 'PlcController::startApplication');

        // Step 1 - Personal Details
        $routes->get('personal-details', 'PlcController::personalDetails');
        $routes->post('process-personal-details', 'PlcController::processPersonalDetails');

        // Step 2 - Company Details
        $routes->get('company-details', 'PlcController::companyDetails');
        $routes->get('business-details', 'PlcController::businessDetails');
        $routes->post('process-company-details', 'PlcController::processCompanyDetails');

        // Step 3 - Directors & Shareholders
        $routes->get('directors-shareholders', 'PlcController::directorsShareholders');
        $routes->post('process-shareholders', 'PlcController::processShareholders');

        // Step 4 - Review & Submit
        $routes->get('review-submit', 'PlcController::reviewSubmit');
        $routes->post('submit-final', 'PlcController::submitFinalApplication');
        $routes->get('confirmation', 'PlcController::confirmation');
    });
       });