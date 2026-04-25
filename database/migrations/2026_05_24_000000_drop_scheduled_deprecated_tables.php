<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

/**
 * Scheduled migration to drop deprecated tables
 * Target deletion date: 2026-05-24
 */
class DropScheduledDeprecatedTables extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('impound_status_histories');
        Schema::dropIfExists('impound_records');
        Schema::dropIfExists('impounds');
        // pet_traits is now used as pivot table for pets <-> traits, so we keep it
    }

    public function down(): void
    {
        // Reversal not implemented - tables are permanently deprecated
    }
}
