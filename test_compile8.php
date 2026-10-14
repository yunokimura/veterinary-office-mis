<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$factory = app('blade.compiler');
$view = app('view');

// Check if view exists using full path
$path = 'resources/views/Client/kapon_form.blade.php';
echo "Checking path: $path\n";
echo "File exists: " . (file_exists($path) ? 'YES' : 'NO') . "\n";

// Try compiling with full path
try {
    $compiled = $factory->compile($path);
    echo "Compiled: " . ($compiled ?: 'EMPTY') . "\n";
    if ($compiled && file_exists($compiled)) {
        $content = file_get_contents($compiled);
        echo "Length: " . strlen($compiled) . "\n";
        echo "Has combined: " . (strpos($compiled, 'general_agreement[combined]') !== false ? 'YES' : 'NO') . "\n";
        echo "Has combined text: " . (strpos($compiled, 'I have read, understood, and agree') !== false ? 'YES' : 'NO') . "\n";
    }
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}