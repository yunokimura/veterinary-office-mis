<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CleanGuestReportTokens extends Command
{
    protected $signature = 'tokens:clean-guest-report';
    protected $description = 'Clean up expired guest report tokens';

    public function handle()
    {
        $now = Carbon::now();
        $deleted = DB::table('guest_report_tokens')
            ->where('expires_at', '<', $now)
            ->delete();

        $this->info("Cleaned up {$deleted} expired guest report tokens.");

        $total = DB::table('guest_report_tokens')->count();
        $this->line("Remaining tokens in system: {$total}");
    }
}