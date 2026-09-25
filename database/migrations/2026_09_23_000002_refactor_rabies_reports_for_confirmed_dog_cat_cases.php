<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('rabies_reports', 'rabies_confirmed')) {
            DB::table('rabies_reports')
                ->where('rabies_confirmed', false)
                ->orWhereNotIn('animal_type', ['dog', 'cat'])
                ->delete();
        }

        Schema::table('rabies_reports', function (Blueprint $table) {
            if (Schema::hasColumn('rabies_reports', 'patient_id')) {
                $table->dropIndex('rabies_reports_patient_id_index');
                $table->dropColumn('patient_id');
            }
        });

        Schema::table('rabies_reports', function (Blueprint $table) {
            if (Schema::hasColumn('rabies_reports', 'status')) {
                $table->dropColumn('status');
            }
        });

        Schema::table('rabies_reports', function (Blueprint $table) {
            if (Schema::hasColumn('rabies_reports', 'rabies_confirmed')) {
                $table->dropColumn('rabies_confirmed');
            }
        });

        Schema::table('rabies_reports', function (Blueprint $table) {
            if (Schema::hasColumn('rabies_reports', 'reported_by')) {
                $table->dropForeign('bite_rabies_reports_reported_by_foreign');
                $table->dropIndex('bite_rabies_reports_reported_by_index');
                $table->dropColumn('reported_by');
            }
        });

        Schema::table('rabies_reports', function (Blueprint $table) {
            if (Schema::hasColumn('rabies_reports', 'reporting_facility')) {
                $table->dropColumn('reporting_facility');
            }
        });

        Schema::table('rabies_reports', function (Blueprint $table) {
            if (Schema::hasColumn('rabies_reports', 'exposure_type')) {
                $table->dropColumn('exposure_type');
            }
        });

        Schema::table('rabies_reports', function (Blueprint $table) {
            if (Schema::hasColumn('rabies_reports', 'category')) {
                $table->dropColumn('category');
            }
        });

        Schema::table('rabies_reports', function (Blueprint $table) {
            if (Schema::hasColumn('rabies_reports', 'bite_site')) {
                $table->dropColumn('bite_site');
            }
        });

        Schema::table('rabies_reports', function (Blueprint $table) {
            if (Schema::hasColumn('rabies_reports', 'wound_management')) {
                $table->dropColumn('wound_management');
            }
        });

        Schema::table('rabies_reports', function (Blueprint $table) {
            if (Schema::hasColumn('rabies_reports', 'post_exposure_prophylaxis')) {
                $table->dropColumn('post_exposure_prophylaxis');
            }
        });

        Schema::dropIfExists('patients');
    }

    public function down(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('suffix')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Other'])->nullable();
            $table->string('contact_number')->nullable();
            $table->string('address')->nullable();
            $table->foreignId('barangay_id')->nullable()->constrained('barangays', 'barangay_id')->onDelete('set null');
            $table->timestamps();
        });

        Schema::table('rabies_reports', function (Blueprint $table) {
            $table->enum('exposure_type', ['bite', 'scratch', 'lick'])->nullable()->after('incident_date');
        });

        Schema::table('rabies_reports', function (Blueprint $table) {
            $table->string('bite_site')->nullable()->after('exposure_type');
        });

        Schema::table('rabies_reports', function (Blueprint $table) {
            $table->enum('category', ['I', 'II', 'III'])->nullable()->after('bite_site');
        });

        Schema::table('rabies_reports', function (Blueprint $table) {
            $table->string('post_exposure_prophylaxis')->nullable()->after('notes');
        });

        Schema::table('rabies_reports', function (Blueprint $table) {
            $table->json('wound_management')->nullable()->after('post_exposure_prophylaxis');
        });

        Schema::table('rabies_reports', function (Blueprint $table) {
            $table->string('reporting_facility')->nullable()->after('facility_name');
        });

        Schema::table('rabies_reports', function (Blueprint $table) {
            $table->foreignId('reported_by')->nullable()->constrained('admin_users', 'id')->onDelete('set null')->after('animal_owner_contact');
        });

        Schema::table('rabies_reports', function (Blueprint $table) {
            $table->boolean('rabies_confirmed')->default(false)->after('action_taken');
        });

        Schema::table('rabies_reports', function (Blueprint $table) {
            $table->enum('status', ['Pending Review', 'Under Review', 'Resolved', 'Closed'])->default('Pending Review')->after('report_number');
        });

        Schema::table('rabies_reports', function (Blueprint $table) {
            $table->foreignId('patient_id')->nullable()->constrained()->onDelete('set null')->after('report_number');
        });
    }
};
