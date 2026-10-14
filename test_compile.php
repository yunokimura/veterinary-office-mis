<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$factory = app('blade.compiler');
$path = 'resources/views/Client/kapon_form.blade.php';
echo "Compiling: $path\n";
$compiled = $factory->compile($path);
echo "Compiled path: " . ($compiled ?: 'EMPTY') . "\n";
if ($compiled && file_exists($compiled)) {
    $compiledContent = file_get_contents($compiled);
    echo "Has combined: " . (str_contains($compiledContent, 'general_agreement[combined]') ? 'YES' : 'NO') . "\n";
    echo "Has combined text: " . (str_contains($compiledContent, 'I have read, understood, and agree') ? 'YES' : 'NO') . "\n";
    echo "Has old fasting: " . (str_contains($compiledContent, 'general_agreement[fasting]') ? 'YES' : 'NO') . "\n";
    echo "Has secure_cage: " . (str_contains($compiledContent, 'general_agreement[secure_cage]') ? 'YES' : 'NO') . "\n";
    echo "Has full_authority: " . (str_contains($compiledContent, 'general_agreement[full_authority]') ? 'YES' : 'NO') . "\n";
    echo "Has valid_id: " . (str_contains($compiledContent, 'general_agreement[valid_id]') ? 'YES' : 'NO') . "\n";
    echo "Has location: " . (str_contains($compiledContent, 'general_agreement[location]') ? 'YES' : 'NO') . "\n";
} else {
    echo "Compilation failed or file not found\n";
}