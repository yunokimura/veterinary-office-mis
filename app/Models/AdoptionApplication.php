<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int|null $owner_id
 * @property int|null $address_id
 * @property int|null $selected_pet_id
 * @property string $company
 * @property string|null $occupation
 * @property string|null $social_media
 * @property string $adopted_before
 * @property string $status
 * @property array<array-key, mixed>|null $alternate_contact
 * @property array<array-key, mixed>|null $questionnaire
 * @property string|null $valid_id_path
 * @property string|null $zoom_interview
 * @property Carbon|null $zoom_date
 * @property string|null $zoom_time
 * @property string|null $zoom_time_ampm
 * @property string|null $shelter_visit
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @property-read Pet|null $pet
 * @property-read PetOwner|null $owner
 * @property-read Address|null $address
 * @property-read string $first_name
 * @property-read string $last_name
 * @property-read string $full_name
 * @property-read string $email
 * @property-read string $mobile_number
 * @property-read string|null $alt_mobile_number
 * @property-read Carbon|null $birth_date
 * @property-read string $blk_lot_ph
 * @property-read string $street
 * @property-read string $barangay
 * @property-read string $full_address
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereAdoptedBefore($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereAltMobileNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereAlternateContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereBarangay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereBirthDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereBlkLotPh($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereMobileNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereOccupation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereQuestionnaire($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereSelectedPetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereShelterVisit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereSocialMedia($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereValidIdPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereZoomDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereZoomInterview($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereZoomTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication whereZoomTimeAmpm($value)
 *
 * @mixin \Eloquent
 */
class AdoptionApplication extends Model
{
    protected $table = 'adoption_applications';

    protected $fillable = [
        'user_id',
        'owner_id',
        'address_id',
        'selected_pet_id',
        'company',
        'occupation',
        'social_media',
        'adopted_before',
        'status',
        'alternate_contact',
        'questionnaire',
        'valid_id_path',
        'zoom_interview',
        'zoom_date',
        'zoom_time',
        'zoom_time_ampm',
        'shelter_visit',
    ];

    protected $casts = [
        'alternate_contact' => 'array',
        'questionnaire' => 'array',
        'zoom_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class, 'selected_pet_id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(PetOwner::class, 'owner_id', 'owner_id');
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    // Backward-compatibility accessors

    public function getFirstNameAttribute(): string
    {
        return $this->owner?->first_name ?? '';
    }

    public function getLastNameAttribute(): string
    {
        return $this->owner?->last_name ?? '';
    }

    public function getFullNameAttribute(): string
    {
        return trim($this->first_name.' '.$this->last_name) ?: 'N/A';
    }

    public function getEmailAttribute(): string
    {
        return $this->user?->email ?? '';
    }

    public function getMobileNumberAttribute(): string
    {
        return $this->owner?->phone_number ?? '';
    }

    public function getAltMobileNumberAttribute(): ?string
    {
        return $this->owner?->alternate_phone_number ?? null;
    }

    public function getBirthDateAttribute(): ?Carbon
    {
        return $this->owner?->date_of_birth ? Carbon::parse($this->owner->date_of_birth) : null;
    }

    public function getBlkLotPhAttribute(): string
    {
        return $this->address?->block_lot_phase ?? '';
    }

    public function getStreetAttribute(): string
    {
        return $this->address?->street ?? '';
    }

    public function getBarangayAttribute(): string
    {
        return $this->address?->barangay?->barangay_name ?? '';
    }

    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->blk_lot_ph,
            $this->street,
            $this->barangay,
        ]);

        return implode(', ', $parts) ?: 'N/A';
    }
}
