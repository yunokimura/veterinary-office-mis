<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
