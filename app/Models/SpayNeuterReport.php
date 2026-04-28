<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int|null $pet_id
 * @property int|null $owner_id
 * @property int|null $barangay_id
 * @property string $procedure_type
 * @property Carbon|null $scheduled_at
 * @property float|null $weight
 * @property string $status
 * @property string|null $remarks
 * @property Carbon $report_date
 * @property string|null $veterinarian
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read array $selected_pets
 * @property-read string $status_badge
 * @property-read User $user
 * @property-read Pet|null $pet
 * @property-read PetOwner|null $owner
 * @property-read Barangay|null $barangay
 * @property-read string $pet_name
 * @property-read string|null $pet_breed
 * @property-read string|null $pet_age
 * @property-read string|null $gender
 * @property-read string|null $species
 * @property-read string $owner_name
 * @property-read string|null $owner_contact
 * @property-read string|null $owner_address
 * @property-read string $barangay_name
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereBarangay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereClinicName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereOwnerAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereOwnerContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereOwnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport wherePetAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport wherePetBreed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport wherePetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport wherePetName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereProcedureType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereReportDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereScheduledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereSpecies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereVeterinarian($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereWeight($value)
 *
 * @mixin \Eloquent
 */
class SpayNeuterReport extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'spay_neuter_reports';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'pet_id',
        'owner_id',
        'barangay_id',
        'procedure_type',
        'scheduled_at',
        'weight',
        'status',
        'remarks',
        'report_date',
        'veterinarian',
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
            'report_date' => 'date',
            'weight' => 'decimal:2',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the user who created this report.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the pet associated with this report.
     */
    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'pet_id');
    }

    /**
     * Get the pet owner (client) associated with this report.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(PetOwner::class, 'owner_id', 'owner_id');
    }

    /**
     * Get the barangay associated with this report.
     */
    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    /**
     * Scope for filtering by procedure type.
     */
    public function scopeByProcedureType($query, $type)
    {
        return $query->where('procedure_type', $type);
    }

    /**
     * Scope for filtering by pet type/species.
     */
    public function scopeByPetType($query, $type)
    {
        return $query->whereHas('pet', function ($q) use ($type) {
            $q->where('species', $type);
        });
    }

    /**
     * Scope for filtering by date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('scheduled_at', [$startDate, $endDate]);
    }

    /**
     * Get status badge color.
     */
    public function getStatusBadgeAttribute(): string
    {
        $colors = [
            'completed' => 'success',
            'scheduled' => 'info',
            'cancelled' => 'danger',
            'pending' => 'warning',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * Accessor for pet_name (legacy compatibility)
     */
    public function getPetNameAttribute(): string
    {
        return $this->pet?->pet_name ?? 'N/A';
    }

    /**
     * Accessor for pet_breed (legacy compatibility)
     */
    public function getPetBreedAttribute(): ?string
    {
        return $this->pet?->breed;
    }

    /**
     * Accessor for pet_age (legacy compatibility)
     */
    public function getPetAgeAttribute(): ?string
    {
        return $this->pet?->estimated_age;
    }

    /**
     * Accessor for gender (legacy compatibility)
     */
    public function getGenderAttribute(): ?string
    {
        return $this->pet?->sex ?? $this->pet?->gender;
    }

    /**
     * Accessor for species (legacy compatibility)
     */
    public function getSpeciesAttribute(): ?string
    {
        return $this->pet?->species;
    }

    /**
     * Accessor for owner_name (legacy compatibility)
     */
    public function getOwnerNameAttribute(): string
    {
        return $this->owner?->full_name ?? 'N/A';
    }

    /**
     * Accessor for owner_contact (legacy compatibility)
     */
    public function getOwnerContactAttribute(): ?string
    {
        return $this->owner?->phone_number ?? null;
    }

    /**
     * Accessor for owner_address (legacy compatibility)
     */
    public function getOwnerAddressAttribute(): ?string
    {
        if (! $this->owner) {
            return null;
        }
        $parts = array_filter([
            $this->owner->blk_lot_ph,
            $this->owner->street,
            $this->owner->barangay,
        ]);

        return implode(', ', $parts);
    }

    /**
     * Accessor for barangay name
     */
    public function getBarangayNameAttribute(): ?string
    {
        return $this->barangay?->barangay_name ?? null;
    }

    /**
     * Accessor for procedure_date (legacy compatibility - alias to scheduled_at)
     */
    public function getProcedureDateAttribute()
    {
        return $this->scheduled_at;
    }

    /**
     * Accessor for pet_type (legacy compatibility - alias to species)
     */
    public function getPetTypeAttribute(): ?string
    {
        return $this->pet?->species;
    }

    /**
     * Accessor for pet_sex (legacy compatibility - alias to gender)
     */
    public function getPetSexAttribute(): ?string
    {
        return $this->gender;
    }

    /**
     * Accessor for color_markings (legacy compatibility - no longer stored)
     */
    public function getColorMarkingsAttribute(): ?string
    {
        return null;
    }

    /**
     * Accessor for clinic_name (legacy compatibility - removed)
     */
    public function getClinicNameAttribute(): ?string
    {
        return null;
    }
}
