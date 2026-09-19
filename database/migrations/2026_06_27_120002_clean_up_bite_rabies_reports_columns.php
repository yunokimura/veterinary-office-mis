<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Remove confusing duplicate columns and keep only the standardized ones
     */
    public function up(): void
    {
        Schema::table('rabies_reports', function (Blueprint $table) {
            // Remove redundant patient_name (we have first_name, middle_name, suffix)
            if (Schema::hasColumn('rabies_reports', 'patient_name')) {
                $table->dropColumn('patient_name');
            }
            
            // Remove redundant patient_age (we have age)
            if (Schema::hasColumn('rabies_reports', 'patient_age')) {
                $table->dropColumn('patient_age');
            }
            
            // Remove redundant patient_gender (we have gender)
            if (Schema::hasColumn('rabies_reports', 'patient_gender')) {
                $table->dropColumn('patient_gender');
            }
            
            // Remove redundant patient_barangay string (we have barangay_id FK)
            if (Schema::hasColumn('rabies_reports', 'patient_barangay')) {
                $table->dropColumn('patient_barangay');
            }
            
            // Remove redundant incident_barangay string (we have barangay_id FK)
            if (Schema::hasColumn('rabies_reports', 'incident_barangay')) {
                $table->dropColumn('incident_barangay');
            }
        });
    }

    /**
     * Reverse the migrations.
     * Add back the columns if needed (data will be lost)
     */
    public function down(): void
    {
        Schema::table('rabies_reports', function (Blueprint $table) {
            // Add back patient_name
            $table->string('patient_name')->after('report_number');
            
            // Add back patient_age
            $table->integer('patient_age')->nullable()->after('patient_name');
            
            // Add back patient_gender
            $table->enum('patient_gender', ['Male', 'Female'])->nullable()->after('patient_age');
            
            // Add back patient_barangay
            $table->string('patient_barangay')->nullable()->after('patient_contact');
            
            // Add back incident_barangay
            $table->string('incident_barangay')->nullable()->after('exact_location');
        });
    }
};