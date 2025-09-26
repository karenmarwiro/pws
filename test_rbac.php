<?php

require __DIR__ . '/vendor/autoload.php';

use App\Core\Services\RBAC;

// Try to create an instance of RBAC
try {
    $rbac = new RBAC();
    echo "RBAC class loaded successfully!\n";
    var_dump($rbac);
} catch (Exception $e) {
    echo "Error loading RBAC class: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
