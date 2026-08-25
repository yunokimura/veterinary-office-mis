<?php

use App\Models\Admin;
use App\Models\Address;
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
        // Backfill addresses from admins.barangay_id before dropping
        $admins = Admin::whereNotNull('barangay_id')->get();

        foreach ($admins as $admin) {
            if ($admin->address) {
                $admin->address->update([
                    'barangay_id' => $admin->barangay_id,
                ]);
            } else {
                Address::create([
                    'addressable_type' => Admin::class,
                    'addressable_id' => $admin->id,
                    'block_lot_phase' => null,
                    'street' => null,
                    'subdivision' => null,
                    'barangay_id' => $admin->barangay_id,
                    'city' => null,
                    'province' => null,
                    'postal_code' => null,
                    'is_primary' => true,
                ]);
            }
        }

        Schema::table('admins', function (Blueprint $table) {
            $table->dropForeign('admins_barangay_id_foreign');
            $table->dropColumn('barangay_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->unsignedBigInteger('barangay_id')->nullable()->after('role_type')->index();
            $table->foreign('barangay_id')->references('barangay_id')->on('barangays')->nullOnDelete();
        });
    }
};
