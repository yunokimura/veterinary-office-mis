<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$factory = app('blade.compiler');

// Check if view exists
$path = 'resources/views/Client/kapon_form.blade.php';
echo "Checking path: $path\n";
echo "File exists: " . (file_exists($path) ? 'YES' : 'NO') . "\n";

$compiled = $factory->compile($path);
var_dump($compiled);

if ($compiled && file_exists($compiled)) {
    $content = file_get_contents($compiled);
    echo "Compiled length: " . strlen($compiled) . "\n";
    echo "Has combined: " . (strpos($compiled, 'general_agreement[combined]') !== false ? 'YES' : 'NO') . "\n";
    echo "Has combined text: " . (strpos($compiledContent, 'I have read, understood, and agree') !== false ? 'YES' : 'NO') . "\n";
} else {
    echo "Compiled path: " . ($compiled ?: 'NULL') . "\n";
    echo "File exists: " . ($compiled && file_exists($compiled) ? 'YES' : 'NO') . "\n";
}