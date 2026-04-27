<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $user_id
 * @property string $clinic_name
 * @property string $patient_name
 * @property string $patient_contact
 * @property string $patient_address
 * @property string|null $pet_name
 * @property string $pet_species
 * @property string|null $pet_breed
 * @property int|null $pet_age
 * @property string|null $pet_gender
 * @property string|null $pet_color
 * @property string $vaccine_brand
 * @property string|null $vaccine_batch_number
 * @property \Illuminate\Support\Carbon $vaccination_date
 * @property mixed $vaccination_time
 * @property \Illuminate\Support\Carbon|null $next_vaccination_date
 * @property numeric|null $weight
 * @property string $vaccination_type
 * @property string|null $observations
 * @property string $status
 * @property string|null $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport completed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport pending()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereClinicName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereNextVaccinationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereObservations($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport wherePatientAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport wherePatientContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport wherePatientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport wherePetAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport wherePetBreed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport wherePetColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport wherePetGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport wherePetName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport wherePetSpecies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereVaccinationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereVaccinationTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereVaccinationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereVaccineBatchNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereVaccineBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesVaccinationReport whereWeight($value)
 * @mixin \Eloquent
 */
class RabiesVaccinationReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'clinic_name',
        'patient_name',
        'patient_contact',
        'patient_address',
        'pet_name',
        'pet_species',
        'pet_breed',
        'pet_age',
        'pet_gender',
        'pet_color',
        'vaccine_brand',
        'vaccine_batch_number',
        'vaccination_date',
        'vaccination_time',
        'next_vaccination_date',
        'weight',
        'vaccination_type',
        'observations',
        'status',
        'notes',
    ];

    protected $casts = [
        'vaccination_date' => 'date',
        'vaccination_time' => 'time',
        'next_vaccination_date' => 'date',
        'pet_age' => 'integer',
        'weight' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
