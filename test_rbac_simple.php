<?php

// Load Composer's autoloader
require __DIR__ . '/vendor/autoload.php';

// Manually include the RBAC class
require_once __DIR__ . '/app/Core/Services/RBAC.php';

// Try to create an instance
try {
    $rbac = new \App\Core\Services\RBAC();
    echo "RBAC class loaded successfully!\n";
    echo "Class: " . get_class($rbac) . "\n";
} catch (\Exception $e) {
    echo "Error creating RBAC instance: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
