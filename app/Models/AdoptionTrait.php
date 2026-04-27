<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Pet> $pets
 * @property-read int|null $pets_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionTrait newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionTrait newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionTrait query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionTrait whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionTrait whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionTrait whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AdoptionTrait whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AdoptionTrait extends Model
{
    use HasFactory;

    protected $table = 'traits';

    protected $fillable = [
        'name',
    ];

    public function pets(): BelongsToMany
    {
        return $this->belongsToMany(Pet::class, 'pet_traits', 'trait_id', 'pet_id')
            ->withTimestamps();
    }
}
