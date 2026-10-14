<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$factory = app('blade.compiler');
$finder = $factory->getFinder();

// List all views
$views = $finder->getViews();
echo "Total views: " . count($views) . "\n";

// Check if our view exists
$path = 'Client/kapon_form';
echo "Looking for: $path\n";
$exists = $finder->exists($path);
echo "Exists: " . ($exists ? 'YES' : 'NO') . "\n";

if ($exists) {
    $compiled = $factory->compile('Client/kapon_form');
    echo "Compiled: " . ($compiled ?: 'EMPTY') . "\n";
    if ($compiled) {
        $content = file_get_contents($compiled);
        echo "Length: " . strlen($compiled) . "\n";
        echo "Has combined: " . (strpos($compiled, 'general_agreement[combined]') !== false ? 'YES' : 'NO') . "\n";
        echo "Has combined text: " . (strpos($compiled, 'I have read, understood, and agree') !== false ? 'YES' : 'NO') . "\n";
    }
}