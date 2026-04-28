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
        Schema::table('users', function (Blueprint $table) {
            // Remove additional legacy columns if they exist
            if (Schema::hasColumn('users', 'secondary_role')) {
                $table->dropColumn('secondary_role');
            }
            if (Schema::hasColumn('users', 'contact_number')) {
                $table->dropColumn('contact_number');
            }
            if (Schema::hasColumn('users', 'address')) {
                $table->dropColumn('address');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add back additional legacy columns for rollback
            if (! Schema::hasColumn('users', 'secondary_role')) {
                $table->enum('secondary_role', [
                    'super_admin',
                    'admin',
                    'city_vet',
                    'admin_staff',
                    'disease_control',
                    'city_pound',
                    'meat_inspector',
                    'veterinarian',
                    'viewer',
                    'barangay_encoder',
                ])->nullable()->after('role');
            }
            if (! Schema::hasColumn('users', 'contact_number')) {
                $table->string('contact_number')->nullable()->after('email_verified_at');
            }
            if (! Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('contact_number');
            }
        });
    }
};
