<?php

/**
 * Railway Debug Script
 * Para ejecutar en Railway shell: php debug-railway.php
 */

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== RAILWAY ENVIRONMENT DEBUG ===\n\n";

echo "1. PHP Version: " . PHP_VERSION . "\n";
echo "2. PHP Extensions:\n";
$extensions = get_loaded_extensions();
foreach ($extensions as $ext) {
    if (strpos(strtolower($ext), 'pdo') !== false || strpos(strtolower($ext), 'mysql') !== false) {
        echo "   - $ext\n";
    }
}

echo "\n3. PDO Drivers:\n";
if (class_exists('PDO')) {
    foreach (PDO::getAvailableDrivers() as $driver) {
        echo "   - $driver\n";
    }
} else {
    echo "   PDO class not available\n";
}

echo "\n4. Database Connection Test:\n";
try {
    $dsn = "mysql:host=" . env('DB_HOST') . ";port=" . env('DB_PORT') . ";dbname=" . env('DB_DATABASE');
    $pdo = new PDO($dsn, env('DB_USERNAME'), env('DB_PASSWORD'));
    echo "   ✓ Raw PDO connection successful\n";
    $pdo = null;
} catch (Exception $e) {
    echo "   ✗ Raw PDO connection failed: " . $e->getMessage() . "\n";
}

echo "\n5. Laravel DB Test:\n";
try {
    $connection = \Illuminate\Support\Facades\DB::connection();
    $tables = \Illuminate\Support\Facades\DB::select('SHOW TABLES');
    echo "   ✓ Laravel DB connection successful\n";
    echo "   ✓ Found " . count($tables) . " tables\n";
} catch (Exception $e) {
    echo "   ✗ Laravel DB connection failed: " . $e->getMessage() . "\n";
}

echo "\n6. Autoloader Test:\n";
try {
    $reflection = new ReflectionClass('PDO');
    echo "   ✓ PDO class loaded from: " . $reflection->getFileName() . "\n";
} catch (Exception $e) {
    echo "   ✗ PDO reflection failed: " . $e->getMessage() . "\n";
}

echo "\n=== END DEBUG ===\n";
