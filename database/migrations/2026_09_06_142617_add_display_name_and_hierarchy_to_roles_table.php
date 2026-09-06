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
        Schema::table('spatie_roles', function (Blueprint $table) {
            $table->string('display_name')->nullable()->after('name');
            $table->text('description')->nullable()->after('display_name');
            $table->unsignedInteger('hierarchy_level')->default(0)->after('description');
        });

        $roles = [
            'super_admin' => ['Super Administrator', 'Full system access', 10],
            'city_vet' => ['City Veterinarian', 'Admin/office head access', 8],
            'assistant_vet' => ['Assistant Veterinarian', 'Assistant vet access', 5],
            'admin_asst' => ['Administrative Assistant', 'Admin assistant access', 5],
            'meat_inspector' => ['Meat Inspector', 'Meat inspection access', 4],
            'pet_owner' => ['Pet Owner', 'Pet owner / citizen portal', 1],
        ];

        foreach ($roles as $name => [$displayName, $description, $level]) {
            \Spatie\Permission\Models\Role::where('name', $name)
                ->update([
                    'display_name' => $displayName,
                    'description' => $description,
                    'hierarchy_level' => $level,
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spatie_roles', function (Blueprint $table) {
            $table->dropColumn(['display_name', 'description', 'hierarchy_level']);
        });
    }
};
