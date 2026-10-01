<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\Pet;

/**
 * @property int $id
 * @property int|null $user_id
 * @property int|null $owner_id
 * @property int|null $address_id
 * @property int|null $pet_id
 * @property \Illuminate\Support\Carbon|null $scheduled_at
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $last_anti_rabies_date
 * @property bool $recent_surgery
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\PetOwner|null $owner
 * @property-read \App\Models\Address|null $address
 * @property-read \App\Models\Pet|null $pet
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\VaccinationReport> $vaccinationReports
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationAppointment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationAppointment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationAppointment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationAppointment whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationAppointment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationAppointment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationAppointment whereLastAntiRabiesDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationAppointment whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationAppointment wherePetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationAppointment whereRecentSurgery($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationAppointment whereScheduledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationAppointment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationAppointment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationAppointment whereUserId($value)
 * @mixin \Eloquent
 */
class VaccinationAppointment extends Model
{
    protected $table = 'vaccination_appointments';

    protected $fillable = [
        'user_id',
        'owner_id',
        'address_id',
        'pet_id',
        'scheduled_at',
        'status',
        'last_anti_rabies_date',
        'recent_surgery',
        'assigned_vet',
        'clinic_name',
        'vaccination_certificate',
        'vaccine_lot_number',
        'vaccination_certificate_path',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'last_anti_rabies_date' => 'date',
        'recent_surgery' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(PetOwner::class, 'owner_id', 'owner_id');
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'pet_id');
    }

    public function vaccinationReports(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(VaccinationReport::class, 'vaccination_appointment_id');
    }

    public function assignedVet(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'assigned_vet');
    }

    public function getOwnerNameAttribute(): string
    {
        return $this->owner ? trim($this->owner->first_name.' '.$this->owner->last_name) : 'N/A';
    }

    public function getAssignedVetNameAttribute(): string
    {
        if ($this->assignedVet && $this->assignedVet->user) {
            return trim($this->assignedVet->user->name);
        }

        return 'N/A';
    }
}
