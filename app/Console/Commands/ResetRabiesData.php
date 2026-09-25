<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ResetRabiesData extends Command
{
    protected $signature = 'reports:reset-rabies-data';
    protected $description = 'Delete all rabies reports, then re-seed with replacement data';

    protected array $seeders = [
        \Database\Seeders\RabiesReportsCsvSeeder::class,
    ];

    public function handle(): int
    {
        $rabiesCount = DB::table('rabies_reports')->count();
        $exposureCount = Schema::hasTable('exposure_cases') ? DB::table('exposure_cases')->count() : 0;
        $notificationCount = DB::table('notifications')
            ->where('related_module', 'bite_rabies_report')
            ->count();

        $this->warn("This will DELETE:");
        $this->warn("  - $rabiesCount rabies_reports");
        $this->warn("  - $exposureCount exposure_cases");
        $this->warn("  - $notificationCount notifications (bite_rabies_report)");
        $this->newLine();

        if (!$this->confirm('Continue?', true)) {
            $this->info('Aborted.');
            return self::SUCCESS;
        }

        $this->info('Clearing data...');

        DB::table('notifications')
            ->where('related_module', 'bite_rabies_report')
            ->delete();

        Schema::disableForeignKeyConstraints();

        if (Schema::hasTable('exposure_cases')) {
            DB::table('exposure_cases')->truncate();
            $this->info('Truncated exposure_cases.');
        }

        DB::table('rabies_reports')->truncate();
        $this->info('Truncated rabies_reports.');

        if (Schema::hasTable('rabies_cases')) {
            DB::table('rabies_cases')->truncate();
            $this->info('Truncated rabies_cases.');
        }

        Schema::enableForeignKeyConstraints();

        $this->newLine();
        $this->info('Running replacement seeders...');

        foreach ($this->seeders as $seeder) {
            $short = class_basename($seeder);
            $this->info("  - $short");
            Artisan::call('db:seed', ['--class' => $seeder, '--force' => true], $this->output);
        }

        $this->newLine();
        $finalReports = DB::table('rabies_reports')->count();

        $this->info("Done.");
        $this->info("  rabies_reports: $finalReports");

        return self::SUCCESS;
    }
}
