<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read \App\Models\User|null $creator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Livestock> $livestock
 * @property-read int|null $livestock_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\RabiesCase> $rabiesCases
 * @property-read int|null $rabies_cases_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Owner active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Owner inBarangay($barangayId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Owner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Owner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Owner query()
 * @mixin \Eloquent
 */
class Owner extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'owners';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'owner_name',
        'contact_number',
        'address',
        'barangay_id',
        'ownership_type',
        'email',
        'status',
        'notes',
        'created_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the rabies cases for this owner.
     */
    public function rabiesCases(): HasMany
    {
        return $this->hasMany(RabiesCase::class, 'owner_id');
    }

    /**
     * Get the livestock records for this owner.
     */
    public function livestock(): HasMany
    {
        return $this->hasMany(Livestock::class, 'owner_id');
    }

    /**
     * Get the user who created this owner record.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope a query to only include active owners.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to filter by barangay.
     */
    public function scopeInBarangay($query, $barangayId)
    {
        return $query->where('barangay_id', $barangayId);
    }
}