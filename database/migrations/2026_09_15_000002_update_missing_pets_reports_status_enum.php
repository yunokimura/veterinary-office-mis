<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('missing_pets_reports')
            ->whereNull('status')
            ->orWhere('status', '')
            ->update(['status' => 'missing']);

        DB::statement("ALTER TABLE missing_pets_reports MODIFY COLUMN status VARCHAR(50) DEFAULT 'pending review' NOT NULL");

        DB::table('missing_pets_reports')
            ->where('status', 'missing')
            ->update(['status' => 'pending review']);

        DB::table('missing_pets_reports')
            ->whereIn('status', ['found', 'reunited'])
            ->update(['status' => 'resolved - reunited']);

        DB::statement("ALTER TABLE missing_pets_reports MODIFY COLUMN status ENUM('pending review', 'approved', 'rejected', 'resolved - reunited', 'resolved - shelter intake', 'closed - expired', 'closed - cancelled', 'closed - duplicate') DEFAULT 'pending review' NOT NULL");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE missing_pets_reports MODIFY COLUMN status VARCHAR(50) DEFAULT 'missing' NOT NULL");

        DB::table('missing_pets_reports')
            ->whereIn('status', ['pending review', 'approved', 'rejected'])
            ->update(['status' => 'missing']);

        DB::table('missing_pets_reports')
            ->whereIn('status', ['resolved - reunited', 'resolved - shelter intake'])
            ->update(['status' => 'found']);

        DB::table('missing_pets_reports')
            ->whereIn('status', ['closed - expired', 'closed - cancelled', 'closed - duplicate'])
            ->update(['status' => 'reunited']);

        DB::statement("ALTER TABLE missing_pets_reports MODIFY COLUMN status ENUM('missing', 'found', 'reunited') DEFAULT 'missing' NOT NULL");
    }
};
