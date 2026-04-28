<?php

use App\Models\Barangay;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('spay_neuter_reports', function (Blueprint $table) {
            $table->unsignedBigInteger('barangay_id')->nullable()->after('owner_id');
            $table->foreign('barangay_id')
                ->references('barangay_id')
                ->on('barangays')
                ->onDelete('set null');
            $table->index('barangay_id');
        });

        // Backfill barangay_id from the barangay string column
        $reports = DB::table('spay_neuter_reports')->whereNotNull('barangay')->get();
        foreach ($reports as $report) {
            $barangay = Barangay::where('barangay_name', $report->barangay)->first();
            if (! $barangay) {
                $barangay = Barangay::create([
                    'barangay_name' => $report->barangay,
                    'city' => 'Dasmariñas City',
                    'province' => 'Cavite',
                    'status' => 'active',
                ]);
            }
            DB::table('spay_neuter_reports')
                ->where('id', $report->id)
                ->update(['barangay_id' => $barangay->barangay_id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('spay_neuter_reports', function (Blueprint $table) {
            $table->dropForeign(['barangay_id']);
            $table->dropColumn('barangay_id');
        });
    }
};
