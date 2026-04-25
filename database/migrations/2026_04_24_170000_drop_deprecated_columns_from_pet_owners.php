<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Backup the table first
        DB::statement('CREATE TABLE IF NOT EXISTS pet_owners_backup_20260424 AS SELECT * FROM pet_owners');

        Schema::table('pet_owners', function (Blueprint $table) {
            $table->dropColumn([
                'blk_lot_ph',
                'street',
                'subdivision',
                'barangay',
                'city',
                'province',
                'email',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pet_owners', function (Blueprint $table) {
            $table->string('blk_lot_ph', 255)->nullable()->after('user_id');
            $table->string('street', 255)->nullable()->after('blk_lot_ph');
            $table->string('subdivision', 255)->nullable()->after('street');
            $table->string('barangay', 100)->nullable()->after('subdivision');
            $table->string('city', 100)->nullable()->after('barangay');
            $table->string('province', 100)->nullable()->after('city');
            $table->string('email', 255)->nullable()->after('province');
        });

        // Restore data from backup
        $columns = [
            'owner_id', 'blk_lot_ph', 'street', 'subdivision',
            'barangay', 'city', 'province', 'email',
        ];
        $rows = DB::table('pet_owners_backup_20260424')->get();
        foreach ($rows as $row) {
            DB::table('pet_owners')
                ->where('owner_id', $row->owner_id)
                ->update([
                    'blk_lot_ph' => $row->blk_lot_ph,
                    'street' => $row->street,
                    'subdivision' => $row->subdivision,
                    'barangay' => $row->barangay,
                    'city' => $row->city,
                    'province' => $row->province,
                    'email' => $row->email,
                ]);
        }
    }
};
