<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MissingPetsReport extends Model
{
    protected $table = 'missing_pets_reports';
    protected $primaryKey = 'report_id';

    protected $fillable = [
        'user_id',
        'pet_id',
        'body_marks',
        'eye_color',
        'collar_harness',
        'last_seen_at',
        'location_barangay',
        'location_description',
        'emergency_contact',
        'status',
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
    ];

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'pet_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}