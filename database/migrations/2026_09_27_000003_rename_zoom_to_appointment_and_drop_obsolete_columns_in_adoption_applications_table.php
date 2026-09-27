<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('adoption_applications', function (Blueprint $table) {
            $table->renameColumn('zoom_date', 'appointment_date');
            $table->renameColumn('zoom_time', 'appointment_time');

            $table->dropColumn([
                'zoom_interview',
                'zoom_time_ampm',
                'shelter_visit',
            ]);
        });
    }

    public function down(): void
    {
        Schema::table('adoption_applications', function (Blueprint $table) {
            $table->enum('zoom_interview', ['Yes', 'No'])->nullable()->after('valid_id_path');
            $table->date('zoom_date')->nullable()->after('zoom_interview');
            $table->time('zoom_time')->nullable()->after('zoom_date');
            $table->string('zoom_time_ampm')->nullable()->after('zoom_time');
            $table->enum('shelter_visit', ['Yes', 'No'])->nullable()->after('zoom_time_ampm');

            $table->renameColumn('appointment_date', 'zoom_date');
            $table->renameColumn('appointment_time', 'zoom_time');
        });
    }
};
