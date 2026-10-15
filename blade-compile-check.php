<?php
// Compile each touched Blade view with Laravel's compiler and php -l the output.
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$files = [
    'resources/views/Client/pet_registration_form.blade.php',
    'resources/views/Client/kapon_form.blade.php',
    'resources/views/Client/vaccination_form.blade.php',
    'resources/views/Client/missing_pets_form.blade.php',
];

$compiler = app('blade.compiler');
$failed = false;

foreach ($files as $file) {
    try {
        $compiled = $compiler->compileString(file_get_contents(__DIR__ . '/' . $file));
        $tmp = tempnam(sys_get_temp_dir(), 'blade_') . '.php';
        file_put_contents($tmp, $compiled);
        exec('php -l ' . escapeshellarg($tmp) . ' 2>&1', $out, $code);
        if ($code === 0) {
            echo "OK   $file\n";
        } else {
            $failed = true;
            echo "FAIL $file\n" . implode("\n", $out) . "\n";
        }
        unlink($tmp);
    } catch (Throwable $e) {
        $failed = true;
        echo "FAIL $file (compile threw): " . $e->getMessage() . "\n";
    }
}

exit($failed ? 1 : 0);
