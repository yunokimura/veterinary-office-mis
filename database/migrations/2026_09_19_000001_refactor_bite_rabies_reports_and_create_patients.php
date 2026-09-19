<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::beginTransaction();
        try {
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

            Schema::rename('bite_rabies_reports', 'rabies_reports');

            Schema::table('rabies_reports', function (Blueprint $table) {
                $table->foreignId('patient_id')->nullable()->constrained()->onDelete('set null')->after('report_number');
                $table->index('patient_id');
            });

            $reports = DB::table('rabies_reports')->get([
                'id',
                'patient_first_name',
                'patient_middle_name',
                'patient_last_name',
                'patient_suffix',
                'gender',
                'patient_contact',
                'patient_address',
                'barangay_id',
            ]);

            foreach ($reports as $report) {
                $patientId = DB::table('patients')->insertGetId([
                    'first_name' => $report->patient_first_name,
                    'middle_name' => $report->patient_middle_name,
                    'last_name' => $report->patient_last_name,
                    'suffix' => $report->patient_suffix,
                    'gender' => $report->gender,
                    'contact_number' => $report->patient_contact,
                    'address' => $report->patient_address,
                    'barangay_id' => $report->barangay_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                DB::table('rabies_reports')
                    ->where('id', $report->id)
                    ->update(['patient_id' => $patientId]);
            }

            Schema::table('rabies_reports', function (Blueprint $table) {
                $columnsToDrop = [];
                foreach ([
                    'patient_name',
                    'patient_first_name',
                    'patient_middle_name',
                    'patient_last_name',
                    'patient_suffix',
                    'age',
                    'gender',
                    'patient_address',
                    'patient_contact',
                    'patient_barangay',
                    'incident_barangay',
                ] as $column) {
                    if (Schema::hasColumn('rabies_reports', $column)) {
                        $columnsToDrop[] = $column;
                    }
                }
                if (!empty($columnsToDrop)) {
                    $table->dropColumn($columnsToDrop);
                }
            });

            DB::statement("
                UPDATE rabies_reports
                SET date_reported = CASE
                    WHEN date_reported LIKE '%/%/%' THEN DATE_FORMAT(STR_TO_DATE(date_reported, '%m/%d/%Y'), '%Y-%m-%d')
                    WHEN date_reported LIKE '%-%-%' THEN date_reported
                    ELSE NULL
                END
                WHERE date_reported IS NOT NULL
            ");
            DB::statement('ALTER TABLE rabies_reports MODIFY date_reported DATE NULL');

            DB::table('rabies_reports')->where('animal_type', 'others')->update(['animal_type' => 'dog']);
            DB::statement('ALTER TABLE rabies_reports MODIFY animal_type ENUM("dog", "cat") NOT NULL');

            Schema::table('rabies_reports', function (Blueprint $table) {
                if (Schema::hasColumn('rabies_reports', 'user_id')) {
                    $table->dropForeign('bite_rabies_reports_user_id_foreign');
                    $table->dropColumn('user_id');
                }
            });

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function down(): void
    {
        Schema::rename('rabies_reports', 'bite_rabies_reports_restore');

        Schema::table('bite_rabies_reports_restore', function (Blueprint $table) {
            $table->dropForeign(['patient_id']);
            $table->dropColumn('patient_id');
        });

        Schema::dropIfExists('patients');

        Schema::table('bite_rabies_reports_restore', function (Blueprint $table) {
            $table->string('patient_name')->after('report_number');
            $table->string('patient_first_name')->nullable()->after('patient_name');
            $table->string('patient_middle_name')->nullable()->after('patient_first_name');
            $table->string('patient_last_name')->nullable()->after('patient_first_name');
            $table->string('patient_suffix')->nullable()->after('patient_last_name');
            $table->integer('age')->nullable()->after('patient_suffix');
            $table->enum('gender', ['Male', 'Female'])->nullable()->after('age');
            $table->string('patient_address')->nullable()->after('gender');
            $table->string('patient_contact', 11)->nullable()->after('patient_address');
            $table->string('patient_barangay')->nullable()->after('patient_contact');
            $table->string('incident_barangay')->nullable()->after('exact_location');
            $table->string('date_reported')->nullable()->after('reporting_facility');
            $table->foreignId('user_id')->nullable()->constrained('admin_users')->onDelete('set null')->after('reported_by');
        });

        DB::statement('ALTER TABLE bite_rabies_reports_restore MODIFY animal_type ENUM("dog", "cat", "others") NOT NULL');

        Schema::rename('bite_rabies_reports_restore', 'bite_rabies_reports');
    }
};
