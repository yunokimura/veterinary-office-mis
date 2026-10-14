<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
$factory = app('blade.compiler');
try {
    $compiled = $factory->compile('resources/views/Client/kapon_form.blade.php');
    if ($compiled) {
        echo "Compiled: " . $compiled . "\n";
    } else {
        echo "Compilation failed\n";
    }
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}