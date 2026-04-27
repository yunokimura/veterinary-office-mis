<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int|null $barangay_id
 * @property int|null $user_id
 * @property string $name
 * @property string $type
 * @property string|null $permit_no
 * @property string|null $address
 * @property string|null $contact_number
 * @property string|null $owner_name
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Barangay|null $barangay
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment byBarangay($barangayId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment byStatus($status)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment byType($type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment search($search)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment whereOwnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment wherePermitNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Establishment whereUserId($value)
 * @mixin \Eloquent
 */
class Establishment extends Model
{
    use HasFactory;

    protected $table = 'establishments';

    protected $fillable = [
        'name',
        'type',
        'owner_name',
        'contact_number',
        'address',
        'barangay_id',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Get the barangay that owns the establishment.
     */
    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class);
    }

    /**
     * Scope to filter by type.
     */
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope to filter by barangay.
     */
    public function scopeByBarangay($query, $barangayId)
    {
        return $query->where('barangay_id', $barangayId);
    }

    /**
     * Scope to filter by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope to search by name.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('owner_name', 'like', '%' . $search . '%');
    }

    /**
     * Scope for active establishments.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get count by type.
     */
    public static function getCountByType()
    {
        return self::selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->get()
            ->pluck('count', 'type');
    }
}
