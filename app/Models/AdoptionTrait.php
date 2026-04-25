<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
