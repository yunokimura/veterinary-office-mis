<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $missing_id
 * @property string $pet_name
 * @property string $species
 * @property string|null $breed
 * @property int|null $age
 * @property numeric|null $weight
 * @property string|null $color
 * @property string $gender
 * @property \Illuminate\Support\Carbon $last_seen_at
 * @property string|null $description
 * @property string $location
 * @property string $status
 * @property string|null $photo_img
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereBreed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereLastSeenAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereMissingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet wherePetName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet wherePhotoImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereSpecies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPet whereWeight($value)
 * @mixin \Eloquent
 */
class MissingPet extends Model
{
    use HasFactory;

    protected $primaryKey = 'missing_id';

    public $incrementing = true;

    protected $casts = [
        'last_seen_at' => 'datetime',
    ];

    protected $fillable = [
        'pet_name',
        'species',
        'breed',
        'age',
        'weight',
        'color',
        'gender',
        'last_seen_at',
        'description',
        'location',
        'photo_img',
        'status',
    ];

    // Traits relationship removed - pet_traits now uses pet_id, not adoption_id
    // public function traits()
    // {
    //     return $this->belongsToMany(AdoptionTrait::class, 'pet_traits', 'adoption_id', 'trait_id')
    //         ->withTimestamps();
    // }

    public function getWeightAttribute($value)
    {
        return $value ? $value.' kg' : null;
    }

    public function getAgeAttribute()
    {
        if (isset($this->attributes['age'])) {
            return $this->attributes['age'];
        }

        if (! $this->date_of_birth) {
            return null;
        }

        $birthDate = Carbon::parse($this->date_of_birth);
        $now = Carbon::now();
        $years = $birthDate->diffInYears($now);

        if ($years < 1) {
            $months = $birthDate->diffInMonths($now);

            return $months.' '.($months === 1 ? 'month' : 'months').' old';
        }

        return $years.' '.($years === 1 ? 'year' : 'years').' old';
    }
}
