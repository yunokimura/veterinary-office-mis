<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property int|null $user_id
 * @property int|null $owner_id
 * @property int|null $address_id
 * @property int|null $barangay_id
 * @property int|null $pet_id
 * @property \Illuminate\Support\Carbon|null $scheduled_at
 * @property string $status
 * @property string|null $procedure_type
 * @property float|null $weight
 * @property array|null $general_agreement
 * @property string|null $veterinarian
 * @property int|null $assigned_vet
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\PetOwner|null $owner
 * @property-read \App\Models\Address|null $address
 * @property-read \App\Models\Barangay|null $barangay
 * @property-read \App\Models\Pet|null $pet
 * @property-read \App\Models\Admin|null $assignedVet
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SpayNeuterReport> $spayNeuterReports
 * @property-read string $pet_name
 * @property-read string $owner_name
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterAppointment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterAppointment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterAppointment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterAppointment whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterAppointment whereAssignedVet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterAppointment whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterAppointment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterAppointment whereGeneralAgreement($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterAppointment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterAppointment whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterAppointment wherePetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterAppointment whereProcedureType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterAppointment whereScheduledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterAppointment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterAppointment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterAppointment whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterAppointment whereVeterinarian($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterAppointment whereWeight($value)
 * @mixin \Eloquent
 */
class SpayNeuterAppointment extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'spay_neuter_appointments';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'owner_id',
        'address_id',
        'barangay_id',
        'pet_id',
        'scheduled_at',
        'status',
        'procedure_type',
        'weight',
        'general_agreement',
        'veterinarian',
        'assigned_vet',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'weight' => 'decimal:2',
            'general_agreement' => 'array',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the user (applicant) who booked this appointment.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the pet owner (client) associated with this appointment.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(PetOwner::class, 'owner_id', 'owner_id');
    }

    /**
     * Get the owner's address.
     */
    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * Get the barangay associated with this appointment.
     */
    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    /**
     * Get the pet associated with this appointment.
     */
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'pet_id');
    }

    /**
     * Get the veterinarian assigned to this appointment.
     */
    public function assignedVet(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'assigned_vet');
    }

    /**
     * Get the reports generated from this appointment.
     */
    public function spayNeuterReports(): HasMany
    {
        return $this->hasMany(SpayNeuterReport::class, 'spay_neuter_appointment_id');
    }

    /**
     * Get the pet's name.
     */
    public function getPetNameAttribute(): string
    {
        return $this->pet ? $this->pet->pet_name : 'N/A';
    }

    /**
     * Get the pet owner's full name.
     */
    public function getOwnerNameAttribute(): string
    {
        if ($this->owner) {
            return trim($this->owner->first_name.' '.$this->owner->last_name);
        }

        return 'N/A';
    }
}
