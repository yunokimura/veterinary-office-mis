<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$factory = app('blade.compiler');
$view = app('view');

// Check if view exists
$path = 'Client/kapon_form';
echo "Checking view: $path\n";
$exists = $view->exists($path);
echo "View exists: " . ($exists ? 'YES' : 'NO') . "\n";

if ($exists) {
    $compiled = $factory->compile($path);
    echo "Compiled: " . ($compiled ?: 'EMPTY') . "\n";
    if ($compiled && file_exists($compiled)) {
        $content = file_get_contents($compiled);
        echo "Length: " . strlen($compiled) . "\n";
        echo "Has combined: " . (strpos($compiled, 'general_agreement[combined]') !== false ? 'YES' : 'NO') . "\n";
        echo "Has combined text: " . (strpos($compiled, 'I have read, understood, and agree') !== false ? 'YES' : 'NO') . "\n";
        echo "Has old fasting: " . (strpos($compiled, 'general_agreement[fasting]') !== false ? 'YES' : 'NO') . "\n";
        echo "Has secure_cage: " . (strpos($compiled, 'general_agreement[secure_cage]') !== false ? 'YES' : 'NO') . "\n";
        echo "Has full_authority: " . (strpos($compiled, 'general_agreement[full_authority]') !== false ? 'YES' : 'NO') . "\n";
        echo "Has valid_id: " . (strpos($compiled, 'general_agreement[valid_id]') !== false ? 'YES' : 'NO') . "\n";
        echo "Has location: " . (strpos($compiled, 'general_agreement[location]') !== false ? 'YES' : 'NO') . "\n";
    }
}