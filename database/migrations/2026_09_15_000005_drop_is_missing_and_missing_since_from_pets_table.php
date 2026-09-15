<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pets', function ($table) {
            $table->dropColumn(['is_missing', 'missing_since']);
        });
    }

    public function down(): void
    {
        Schema::table('pets', function ($table) {
            $table->boolean('is_missing')->default(false)->after('pet_status');
            $table->timestamp('missing_since')->nullable()->after('is_missing');
        });
    }
};
