<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $pet_id
 * @property int|null $owner_id
 * @property string $pet_name
 * @property string $species
 * @property string $breed
 * @property string $gender
 * @property \Illuminate\Support\Carbon|null $birthdate
 * @property string|null $pet_image
 * @property string $vaccination_status
 * @property string|null $vaccination_date
 * @property string|null $next_vaccination_date
 * @property string|null $is_neutered
 * @property string|null $is_crossbreed
 * @property string|null $estimated_age
 * @property string|null $pet_weight
 * @property string|null $body_mark_image
 * @property string|null $body_mark_details
 * @property string|null $training
 * @property string|null $insurance
 * @property string|null $behavior
 * @property string|null $likes
 * @property string|null $dislikes
 * @property string|null $diet
 * @property string|null $allergy
 * @property string|null $source_module
 * @property int|null $source_module_id
 * @property bool $is_approved
 * @property \Illuminate\Support\Carbon|null $consolidated_at
 * @property string $pet_status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Barangay|null $barangay
 * @property-read mixed $age
 * @property-read mixed $date_of_birth
 * @property-read mixed $description
 * @property-read mixed $image
 * @property-read mixed $is_age_estimated
 * @property-read mixed $weight
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MedicalRecord> $medicalRecords
 * @property-read int|null $medical_records_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\MissingPetsReport> $missingReport
 * @property-read int|null $missing_report_count
 * @property-read \App\Models\PetOwner|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AdoptionTrait> $traits
 * @property-read int|null $traits_count
 * @property-read \App\Models\User|null $userOwner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Vaccination> $vaccinations
 * @property-read int|null $vaccinations_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet availableForAdoption()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereAllergy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereBehavior($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereBodyMarkDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereBodyMarkImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereBreed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereConsolidatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereDiet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereDislikes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereEstimatedAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereInsurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereIsCrossbreed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereIsNeutered($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereLikes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereNextVaccinationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet wherePetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet wherePetImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet wherePetName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet wherePetStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet wherePetWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereSourceModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereSourceModuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereSpecies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereTraining($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereVaccinationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereVaccinationStatus($value)
 * @mixin \Eloquent
 */
class Pet extends Model
{
    protected $table = 'pets';

    protected $primaryKey = 'pet_id';

    public $timestamps = false;

    protected $fillable = [
        'owner_id',
        'barangay_id',
        'pet_name',
        'species',
        'breed',
        'gender',
        'color',
        'weight',
        'vaccination_status',
        'vaccination_date',
        'next_vaccination_date',
        'microchip_number',
        'health_status',
        'medical_history',
        'notes',
        'pet_image',
        'birthdate',
        'body_mark_details',
        'body_mark_image',
        'is_neutered',
        'is_crossbreed',
        'training',
        'insurance',
        'behavior',
        'likes',
        'dislikes',
        'diet',
        'allergy',
        'source_module',
        'source_module_id',
        'is_approved',
        'consolidated_at',
        'pet_status',
        'estimated_age',
        'pet_weight',
    ];

    protected $casts = [
        'birthdate' => 'date',
        'is_approved' => 'boolean',
        'consolidated_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(PetOwner::class, 'owner_id');
    }

    public function userOwner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id', 'id');
    }

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    public function vaccinations(): HasMany
    {
        return $this->hasMany(Vaccination::class, 'pet_id');
    }

    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class, 'pet_id');
    }

    public function missingReport(): HasMany
    {
        return $this->hasMany(MissingPetsReport::class, 'pet_id', 'pet_id');
    }

    public function traits(): BelongsToMany
    {
        return $this->belongsToMany(AdoptionTrait::class, 'pet_traits', 'pet_id', 'trait_id')
            ->withTimestamps();
    }

    /**
     * Scope for pets available for adoption (approved + correct source + status).
     */
    public function scopeAvailableForAdoption($query)
    {
        return $query->where('source_module', 'adoption_pets')
            ->where('pet_status', 'available')
            ->where('is_approved', true);
    }

    // Accessors for compatibility with adoption_pets views
    public function getImageAttribute($value)
    {
        return $this->pet_image;
    }

    public function getAgeAttribute()
    {
        if ($this->birthdate) {
            return (int) $this->birthdate->diffInYears(now());
        }
        if ($this->estimated_age) {
            $num = preg_replace('/\D/', '', $this->estimated_age);

            return is_numeric($num) ? (int) $num : null;
        }

        return null;
    }

    public function getDescriptionAttribute()
    {
        return $this->notes;
    }

    public function getWeightAttribute()
    {
        return $this->pet_weight;
    }

    public function getDateOfBirthAttribute($value)
    {
        return $this->birthdate;
    }

    public function getIsAgeEstimatedAttribute()
    {
        return ! empty($this->estimated_age);
    }
}
