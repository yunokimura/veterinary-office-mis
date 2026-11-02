<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use App\Support\PetAge;

/**
 * @property int $pet_id
 * @property string|null $is_neutered
 * @property string|null $is_crossbreed
 * @property string|null $pet_age
 * @property string|null $pet_weight
 * @property array<array-key, mixed>|null $training
 * @property array<array-key, mixed>|null $insurance
 * @property array<array-key, mixed>|null $behavior
 * @property array<array-key, mixed>|null $likes
 * @property array<array-key, mixed>|null $dislikes
 * @property array<array-key, mixed>|null $diet
 * @property array<array-key, mixed>|null $allergy
 * @property string|null $eye_color
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Pet|null $pet
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetInfo newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetInfo newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetInfo query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetInfo whereAllergy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetInfo whereBehavior($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetInfo whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetInfo whereDiet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetInfo whereDislikes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetInfo whereEyeColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetInfo whereInsurance($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetInfo whereIsCrossbreed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetInfo whereIsNeutered($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetInfo whereLikes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetInfo wherePetAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetInfo wherePetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetInfo wherePetWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetInfo whereTraining($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetInfo whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class PetInfo extends Model
{
    protected $table = 'pet_info';

    protected $primaryKey = 'pet_id';

    public $incrementing = false;

    protected $fillable = [
        'pet_id',
        'is_neutered',
        'is_crossbreed',
        'pet_age',
        'pet_weight',
        'training',
        'insurance',
        'behavior',
        'likes',
        'dislikes',
        'diet',
        'allergy',
        'eye_color',
    ];

    protected $casts = [
        'training' => 'array',
        'insurance' => 'array',
        'behavior' => 'array',
        'likes' => 'array',
        'dislikes' => 'array',
        'diet' => 'array',
        'allergy' => 'array',
    ];

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'pet_id');
    }

    public function getPetAgeAttribute($value)
    {
        if ($this->pet && $this->pet->birthdate) {
            return PetAge::compute($this->pet->birthdate);
        }

        return $value;
    }

    public function getPetAgeShortAttribute()
    {
        $age = $this->pet_age;

        if (! $age) {
            return null;
        }

        preg_match('/(\d+)\s*year/', $age, $yearsMatch);
        preg_match('/(\d+)\s*month/', $age, $monthsMatch);

        $years = $yearsMatch[1] ?? null;
        $months = $monthsMatch[1] ?? null;

        if ($years !== null) {
            $yrLabel = (int) $years === 1 && ($months === null || (int) $months === 0) ? ' year' : ' yrs';
            $label = $years . $yrLabel;
            if ($months !== null && (int) $months > 0) {
                $label .= ' ' . $months . ' mos';
            }

            return $label;
        }

        if ($months !== null) {
            return $months . ' months';
        }

        return $age;
    }
}
