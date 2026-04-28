<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->dropColumn([
                'owner_first_name',
                'owner_last_name',
                'owner_email',
                'owner_contact',
                'alt_mobile_number',
                'blk_lot_ph',
                'street',
                'barangay',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vaccination_reports', function (Blueprint $table) {
            $table->string('owner_first_name')->after('user_id');
            $table->string('owner_last_name')->after('owner_first_name');
            $table->string('owner_email')->after('owner_last_name');
            $table->string('owner_contact')->after('owner_email');
            $table->string('alt_mobile_number')->nullable()->after('owner_contact');
            $table->string('blk_lot_ph')->after('alt_mobile_number');
            $table->string('street')->after('blk_lot_ph');
            $table->string('barangay')->after('street');
        });
    }
};
