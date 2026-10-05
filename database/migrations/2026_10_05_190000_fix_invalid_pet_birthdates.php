<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Clears invalid MySQL zero-dates ("0000-00-00") stored in pets.birthdate.
     * These are not real dates and break Carbon parsing; setting them to NULL
     * lets the Pet model fall back to the stored pet_info.pet_age value.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('pets')
            ->whereNull('deleted_at')
            ->whereNotNull('birthdate')
            ->whereRaw('YEAR(birthdate) < 1')
            ->update(['birthdate' => null]);

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * NOTE: The original invalid values cannot be recovered after being
     * cleared, so the reverse is a no-op.
     */
    public function down(): void
    {
        // No-op: invalid zero-dates are not restorable.
    }
};
