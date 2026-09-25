<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $genders = ['male', 'female'];

        DB::table('rabies_reports')
            ->whereNotNull('animal_name')
            ->whereNotNull('animal_owner_name')
            ->whereNull('animal_gender')
            ->orderBy('id')
            ->chunk(100, function ($reports) use ($genders) {
                foreach ($reports as $report) {
                    DB::table('rabies_reports')
                        ->where('id', $report->id)
                        ->update([
                            'animal_gender' => $genders[array_rand($genders)],
                        ]);
                }
            });
    }

    public function down(): void
    {
        DB::table('rabies_reports')
            ->whereNotNull('animal_name')
            ->whereNotNull('animal_owner_name')
            ->update(['animal_gender' => null]);
    }
};
