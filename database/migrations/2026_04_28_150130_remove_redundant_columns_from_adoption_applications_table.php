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
        Schema::table('adoption_applications', function (Blueprint $table) {
            $table->dropColumn([
                'first_name',
                'last_name',
                'email',
                'mobile_number',
                'alt_mobile_number',
                'birth_date',
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
        Schema::table('adoption_applications', function (Blueprint $table) {
            $table->string('first_name')->after('user_id');
            $table->string('last_name')->after('first_name');
            $table->string('email')->after('last_name');
            $table->string('mobile_number')->after('email');
            $table->string('alt_mobile_number')->nullable()->after('mobile_number');
            $table->date('birth_date')->nullable()->after('alt_mobile_number');
            $table->string('blk_lot_ph')->after('birth_date');
            $table->string('street')->after('blk_lot_ph');
            $table->string('barangay')->after('street');
        });
    }
};
