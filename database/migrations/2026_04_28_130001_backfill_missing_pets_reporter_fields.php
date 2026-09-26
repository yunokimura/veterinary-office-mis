<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        \App\Models\MissingPetsReport::whereNull('reporter_contact')
            ->whereNotNull('emergency_contact')
            ->update(['reporter_contact' => \Illuminate\Support\Facades\DB::raw('emergency_contact')]);

        \App\Models\MissingPetsReport::whereNull('reported_by_name')
            ->whereHas('user')
            ->each(function ($report) {
                $name = $report->user->name;
                if ($name) {
                    $report->update(['reported_by_name' => $name]);
                }
            });

        \App\Models\MissingPetsReport::whereNull('report_type')
            ->update(['report_type' => 'missing']);
    }

    public function down(): void
    {
    }
};
