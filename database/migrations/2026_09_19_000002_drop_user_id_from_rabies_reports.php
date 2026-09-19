<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rabies_reports', function (Blueprint $table) {
            if (Schema::hasColumn('rabies_reports', 'user_id')) {
                $table->dropForeign('bite_rabies_reports_user_id_foreign');
                $table->dropColumn('user_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('rabies_reports', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->constrained('admin_users')->onDelete('set null')->after('reported_by');
        });
    }
};
