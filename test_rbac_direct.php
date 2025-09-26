<?php

// Bootstrap CodeIgniter
require __DIR__ . '/app/Config/Paths.php';
$paths = new Config\Paths();

// Load environment settings
require __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable($paths->rootDirectory);
$dotenv->load();

// Load the framework
require $paths->systemDirectory . '/bootstrap.php';

// Create the container
$container = new CodeIgniter\Config\Services();

// Test loading RBAC class
try {
    $rbac = new \App\Core\Services\RBAC();
    echo "RBAC class loaded successfully!\n";
    echo "Class: " . get_class($rbac) . "\n";
} catch (\Exception $e) {
    echo "Error loading RBAC class: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
