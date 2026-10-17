<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int|null $vaccination_appointment_id
 * @property int|null $pet_id
 * @property int|null $barangay_id
 * @property string|null $pet_name
 * @property string|null $pet_species
 * @property string|null $pet_breed
 * @property string|null $pet_gender
 * @property int|null $pet_age
 * @property string|null $vaccine_brand
 * @property string|null $vaccine_batch_number
 * @property \Illuminate\Support\Carbon|null $vaccination_date
 * @property \Illuminate\Support\Carbon|null $vaccination_time
 * @property \Illuminate\Support\Carbon|null $next_vaccination_date
 * @property float|null $weight
 * @property string|null $vaccination_type
 * @property string $status
 * @property string|null $observations
 * @property string|null $notes
 * @property int|null $administered_by
 * @property int|null $inventory_control_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\VaccinationAppointment|null $vaccinationAppointment
 * @property-read \App\Models\Pet|null $pet
 * @property-read \App\Models\Barangay|null $barangay
 * @property-read \App\Models\User|null $administeredBy
 * @property-read \App\Models\InventoryControl|null $inventoryControl
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereAdministeredBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereInventoryControlId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereNextVaccinationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereObservations($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport wherePetAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport wherePetBreed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport wherePetGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport wherePetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport wherePetName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport wherePetSpecies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereVaccinationAppointmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereVaccinationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereVaccinationTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereVaccinationType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereVaccineBatchNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereVaccineBrand($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereWeight($value)
 * @property bool $not_vaccinated
 * @property array<array-key, mixed>|null $vaccination_records
 * @property array<array-key, mixed>|null $anti_rabies_details
 * @property string|null $vaccination_card_path
 * @property-read string $status_badge
 * @property-read \App\Models\PetOwner|null $owner
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereAntiRabiesDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereNotVaccinated($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereVaccinationCardPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereVaccinationRecords($value)
 * @mixin \Eloquent
 */
class VaccinationReport extends Model
{
    protected $table = 'vaccination_reports';

    protected $fillable = [
        'vaccination_appointment_id',
        'pet_id',
        'barangay_id',
        'pet_name',
        'pet_species',
        'pet_breed',
        'pet_gender',
        'pet_age',
        'vaccine_brand',
        'vaccine_batch_number',
        'vaccination_date',
        'vaccination_time',
        'next_vaccination_date',
        'weight',
        'vaccination_type',
        'status',
        'observations',
        'notes',
        'administered_by',
        'inventory_control_id',
        'not_vaccinated',
        'vaccination_records',
        'anti_rabies_details',
        'vaccination_card_path',
        'user_id',
    ];

    protected $casts = [
        'vaccination_date' => 'date',
        'vaccination_time' => 'datetime:H:i',
        'next_vaccination_date' => 'date',
        'pet_age' => 'string',
        'weight' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'vaccination_records' => 'array',
        'anti_rabies_details' => 'array',
        'not_vaccinated' => 'boolean',
    ];

    public function vaccinationAppointment(): BelongsTo
    {
        return $this->belongsTo(VaccinationAppointment::class, 'vaccination_appointment_id');
    }

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'pet_id');
    }

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    public function administeredBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'administered_by');
    }

    public function inventoryControl(): BelongsTo
    {
        return $this->belongsTo(InventoryControl::class, 'inventory_control_id');
    }

    public function owner()
    {
        return $this->hasOneThrough(
            PetOwner::class,
            Pet::class,
            'pet_id',
            'owner_id',
            'pet_id',
            'owner_id'
        );
    }

    public function getStatusBadgeAttribute(): string
    {
        $colors = [
            'completed' => 'success',
            'pending' => 'warning',
            'adverse_reaction' => 'danger',
        ];

        return $colors[$this->status] ?? 'secondary';
    }
}
