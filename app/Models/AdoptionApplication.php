<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $mobile_number
 * @property string|null $alt_mobile_number
 * @property string $blk_lot_ph
 * @property string $street
 * @property string $barangay
 * @property \Illuminate\Support\Carbon|null $birth_date
 * @property string|null $occupation
 * @property string $company
 * @property string|null $social_media
 * @property string $adopted_before
 * @property string $status
 * @property string|null $alternate_contact
 * @property array<array-key, mixed>|null $questionnaire
 * @property string|null $valid_id_path
 * @property string|null $zoom_interview
 * @property \Illuminate\Support\Carbon|null $zoom_date
 * @property string|null $zoom_time
 * @property string|null $zoom_time_ampm
 * @property string|null $shelter_visit
 * @property int|null $selected_pet_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pet|null $pet
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionApplication query()
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
 * @mixin \Eloquent
 */
class AdoptionApplication extends Model
{
    protected $table = 'adoption_applications';

    protected $primaryKey = 'id';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'mobile_number',
        'alt_mobile_number',
        'blk_lot_ph',
        'street',
        'barangay',
        'birth_date',
        'occupation',
        'company',
        'social_media',
        'adopted_before',
        'status',
        'questionnaire',
        'zoom_interview',
        'zoom_date',
        'zoom_time',
        'zoom_time_ampm',
        'shelter_visit',
        'selected_pet_id',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'zoom_date' => 'date',
        'questionnaire' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class, 'selected_pet_id');
    }
}
