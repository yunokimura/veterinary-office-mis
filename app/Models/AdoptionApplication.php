<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
