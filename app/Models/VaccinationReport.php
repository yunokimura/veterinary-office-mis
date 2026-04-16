<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VaccinationReport extends Model
{
    protected $table = 'vaccination_reports';

    protected $fillable = [
        'user_id',
        'appointment_id',
        'owner_first_name',
        'owner_last_name',
        'owner_email',
        'owner_contact',
        'alt_mobile_number',
        'blk_lot_ph',
        'street',
        'barangay',
        'scheduled_at',
        'last_anti_rabies_date',
        'recent_surgery',
        'status',
        'metadata',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'last_anti_rabies_date' => 'date',
        'recent_surgery' => 'boolean',
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getSelectedPetsAttribute(): array
    {
        return $this->metadata['selected_pets'] ?? [];
    }

    public function getStatusBadgeAttribute(): string
    {
        $colors = [
            'pending' => 'warning',
            'approved' => 'info',
            'completed' => 'success',
            'cancelled' => 'danger',
            'no_show' => 'secondary',
        ];
        return $colors[$this->status] ?? 'secondary';
    }
}