<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->unsignedInteger('age')->nullable()->after('date_of_birth');
        });

        DB::table('patients')->whereNotNull('date_of_birth')->update([
            'age' => DB::raw('TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE())'),
        ]);
    }

    public function down(): void
    {
        Schema::table('patients', function (Blueprint $table) {
            $table->dropColumn('age');
        });
    }
};
