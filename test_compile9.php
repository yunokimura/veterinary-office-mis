<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$factory = app('blade.compiler');

$path = 'resources/views/Client/kapon_form.blade.php';
echo "Checking: $path\n";

try {
    // Use reflection to call the protected compileString method
    $reflection = new ReflectionClass($factory);
    $method = $reflection->getMethod('compileString');
    $method->setAccessible(true);
    
    $content = file_get_contents($path);
    $compiled = $method->invoke($factory, $content, $path);
    
    echo "Compiled length: " . strlen($compiled) . "\n";
    echo "Has combined: " . (strpos($compiled, 'general_agreement[combined]') !== false ? 'YES' : 'NO') . "\n";
    echo "Has combined text: " . (strpos($compiled, 'I have read, understood, and agree') !== false ? 'YES' : 'NO') . "\n";
    echo "Has old fasting: " . (strpos($compiled, 'general_agreement[fasting]') !== false ? 'YES' : 'NO') . "\n";
    echo "Has secure_cage: " . (strpos($compiled, 'general_agreement[secure_cage]') !== false ? 'YES' : 'NO') . "\n";
    echo "Has full_authority: " . (strpos($compiled, 'general_agreement[full_authority]') !== false ? 'YES' : 'NO') . "\n";
    echo "Has valid_id: " . (strpos($compiled, 'general_agreement[valid_id]') !== false ? 'YES' : 'NO') . "\n";
    echo "Has location: " . (strpos($compiled, 'general_agreement[location]') !== false ? 'YES' : 'NO') . "\n";
    
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}