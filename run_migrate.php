<?php

use App\Console\Commands\MigrateProfilesAndAddresses;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\ConsoleOutput;

// Run migration with dry-run
$command = new MigrateProfilesAndAddresses;
$command->setLaravel(app());

// Simulate --dry-run
$input = new ArgvInput(['run_migrate.php', '--dry-run']);
$output = new ConsoleOutput;

$command->run($input, $output);
