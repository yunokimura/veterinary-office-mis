<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $pet_id
 * @property int $vaccinated_by
 * @property string $vaccine_type
 * @property \Illuminate\Support\Carbon $vaccination_date
 * @property \Illuminate\Support\Carbon|null $next_vaccination_date
 * @property string|null $batch_number
 * @property \App\Models\User|null $veterinarian
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pet $pet
 * @property-read \App\Models\User|null $vaccinatedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination whereBatchNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination whereNextVaccinationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination wherePetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination whereVaccinatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination whereVaccinationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination whereVaccineType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Vaccination whereVeterinarian($value)
 * @mixin \Eloquent
 */
class Vaccination extends Model
{
    protected $table = 'vaccinations';

    protected $fillable = [
        'pet_id',
        'vaccinated_by',
        'vaccine_type',
        'vaccination_date',
        'next_vaccination_date',
        'batch_number',
        'veterinarian',
        'notes',
    ];

    protected $casts = [
        'vaccination_date' => 'date',
        'next_vaccination_date' => 'date',
    ];

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class, 'pet_id');
    }

    public function vaccinatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vaccinated_by', 'id');
    }

    public function veterinarian(): BelongsTo
    {
        return $this->belongsTo(User::class, 'vaccinated_by', 'id');
    }
}