<?php

// Load the framework
require __DIR__ . '/vendor/autoload.php';

// Load the framework
$paths = new Config\Paths();

// Load environment settings
$dotenv = Dotenv\Dotenv::createImmutable($paths->rootDirectory);
$dotenv->load();

// Build the container for the application
$app = Config\Services::getSharedInstance();

// Get the RBAC service
try {
    $rbac = service('rbac');
    echo "RBAC service loaded successfully!\n";
    echo "RBAC class: " . get_class($rbac) . "\n";
} catch (\Exception $e) {
    echo "Error loading RBAC service: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
