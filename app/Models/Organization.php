<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Organization extends Model
{
    protected $fillable = [
        'type',
        'name',
        'contact_user_id',
        'contact_number',
        'official_email',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the contact user (person managing this organization).
     */
    public function contactUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'contact_user_id');
    }

    /**
     * Get the address associated with this organization (polymorphic).
     */
    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
