<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property int $pet_id
 * @property int|null $owner_id
 * @property string $pet_name
 * @property string $species
 * @property string $breed
 * @property string $gender
 * @property Carbon|null $birthdate
 * @property string|null $pet_image
 * @property string $vaccination_status
 * @property string|null $vaccination_date
 * @property string|null $next_vaccination_date
 * @property string|null $body_mark_image
 * @property string|null $body_mark_details
 * @property string|null $source_module
 * @property int|null $source_module_id
 * @property bool $is_approved
 * @property Carbon|null $consolidated_at
 * @property string $pet_status
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Barangay|null $barangay
 * @property-read mixed $age
 * @property-read mixed $date_of_birth
 * @property-read mixed $description
 * @property-read mixed $image
 * @property-read mixed $is_age_estimated
 * @property-read mixed $weight
 * @property-read PetInfo|null $petInfo
 * @property-read Collection<int, MedicalRecord> $medicalRecords
 * @property-read int|null $medical_records_count
 * @property-read Collection<int, MissingPetsReport> $missingReport
 * @property-read int|null $missing_report_count
 * @property-read PetOwner|null $owner
 * @property-read Collection<int, AdoptionTrait> $traits
 * @property-read int|null $traits_count
 * @property-read User|null $userOwner
 * *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet availableForAdoption()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereBodyMarkDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereBodyMarkImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereBreed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereConsolidatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereIsApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet wherePetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet wherePetImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet wherePetName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet wherePetStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereSourceModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereSourceModuleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereSpecies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereVaccinationDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereVaccinationStatus($value)
 *                                                                                                 *
 * @property array<array-key, mixed>|null $additional_photos
 * @property Carbon|null $deleted_at
 * @property-read mixed $image_url
 * @property-read Collection<int, \App\Models\SpayNeuterReport> $spayNeuterReports
 * @property-read int|null $spay_neuter_reports_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereAdditionalPhotos($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Pet withoutTrashed()
 * @mixin \Eloquent
 */
class Pet extends Model
{
    use SoftDeletes;

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
        'additional_photos',
        'source_module',
        'source_module_id',
        'is_approved',
        'consolidated_at',
        'pet_status',
    ];

    protected $casts = [
        'birthdate' => 'date',
        'is_approved' => 'boolean',
        'consolidated_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
        'additional_photos' => 'array',
    ];

    public function petInfo(): HasOne
    {
        return $this->hasOne(PetInfo::class, 'pet_id', 'pet_id');
    }

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

    public function spayNeuterReports(): HasMany
    {
        return $this->hasMany(SpayNeuterReport::class, 'pet_id', 'pet_id');
    }

    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class, 'pet_id');
    }

    public function vaccinationReports(): HasMany
    {
        return $this->hasMany(VaccinationReport::class, 'pet_id', 'pet_id');
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
            ->where('pet_status', 'for adoption')
            ->where('is_approved', true);
    }

    // Accessors for compatibility with adoption_pets views
    public function getImageAttribute($value)
    {
        return $this->pet_image;
    }

    /**
     * Resolve the pet image to a usable public URL.
     *
     * pet_image values follow several storage conventions across modules:
     * - Full relative public path (e.g. "images/adoption pets/acacia.jpg")
     * - Storage disk path (e.g. "pets/abc.jpg", "missing-pets/abc.jpg")
     * - Legacy bare filename stored under public/images/missing pets
     */
    public function getImageUrlAttribute()
    {
        $raw = $this->pet_image;

        if (! $raw) {
            return null;
        }

        if (str_starts_with($raw, 'http://') || str_starts_with($raw, 'https://')) {
            return $raw;
        }

        $path = ltrim($raw, '/');

        if (file_exists(public_path($path))) {
            return str_replace(' ', '%20', asset($path));
        }

        if (file_exists(storage_path('app/public/'.$path))) {
            return asset('storage/'.$path);
        }

        foreach (['images/missing pets', 'images/adoption pets', 'images/pets', 'images'] as $directory) {
            $candidate = public_path($directory.'/'.$path);
            if (file_exists($candidate)) {
                return str_replace(' ', '%20', asset($directory.'/'.$path));
            }

            // Legacy records may store the wrong file extension.
            $baseName = pathinfo($path, PATHINFO_FILENAME);
            foreach (['jpeg', 'jpg', 'png', 'webp'] as $extension) {
                $alternative = $directory.'/'.$baseName.'.'.$extension;
                if (file_exists(public_path($alternative))) {
                    return str_replace(' ', '%20', asset($alternative));
                }
            }
        }

        return null;
    }

    /**
     * Resolve the body mark image to a usable public URL.
     *
     * body_mark_image values follow several storage conventions:
     * - Full relative public path (e.g. "images/pets/abc.jpg")
     * - Storage disk path (e.g. "pets/abc.jpg", "missing-pets/abc.jpg")
     * - Legacy bare filename stored under public/images/missing pets
     */
    public function getBodyMarkImageUrlAttribute()
    {
        $raw = $this->body_mark_image;

        if (! $raw) {
            return null;
        }

        if (str_starts_with($raw, 'http://') || str_starts_with($raw, 'https://')) {
            return $raw;
        }

        $path = ltrim($raw, '/');

        if (file_exists(public_path($path))) {
            return str_replace(' ', '%20', asset($path));
        }

        if (file_exists(storage_path('app/public/'.$path))) {
            return asset('storage/'.$path);
        }

        foreach (['images/missing pets', 'images/adoption pets', 'images/pets', 'images'] as $directory) {
            $candidate = public_path($directory.'/'.$path);
            if (file_exists($candidate)) {
                return str_replace(' ', '%20', asset($directory.'/'.$path));
            }

            $baseName = pathinfo($path, PATHINFO_FILENAME);
            foreach (['jpeg', 'jpg', 'png', 'webp'] as $extension) {
                $alternative = $directory.'/'.$baseName.'.'.$extension;
                if (file_exists(public_path($alternative))) {
                    return str_replace(' ', '%20', asset($alternative));
                }
            }
        }

        return null;
    }

    public function getAgeAttribute()
    {
        if ($this->birthdate) {
            return (int) $this->birthdate->diffInYears(now());
        }

        $petAge = $this->petInfo?->pet_age;
        if ($petAge) {
            return $petAge;
        }

        return null;
    }

    public function getDescriptionAttribute()
    {
        return $this->notes;
    }

    public function getWeightAttribute()
    {
        return $this->petInfo?->pet_weight;
    }

    public function getDateOfBirthAttribute($value)
    {
        return $this->birthdate;
    }

    public function getIsAgeEstimatedAttribute()
    {
        return false;
    }
}
