<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string|null $log_name
 * @property string|null $description
 * @property string|null $subject_type
 * @property int|null $subject_id
 * @property string|null $event
 * @property string|null $properties
 * @property int|null $causer_id
 * @property string|null $causer_type
 * @property string|null $user_agent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $module
 * @property string|null $action
 * @property string|null $status
 * @property int|null $record_id
 * @property string|null $ip_address
 * @property int|null $user_id
 * @property string|null $role
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog byAction($action)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog byModule($module)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog byStatus($status)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog byUser($userId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog dateRange($startDate, $endDate)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereCauserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereCauserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereEvent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereLogName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereModule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereProperties($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereSubjectId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereSubjectType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereUserAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SystemLog whereUserId($value)
 * @mixin \Eloquent
 */
class SystemLog extends Model
{
    use HasFactory;

    protected $primaryKey = 'log_id';
    protected $fillable = [
        'user_id',
        'role',
        'action',
        'module',
        'record_id',
        'description',
        'ip_address',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user that owns the log.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope for filtering by module.
     */
    public function scopeByModule($query, $module)
    {
        return $query->where('module', $module);
    }

    /**
     * Scope for filtering by action.
     */
    public function scopeByAction($query, $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Scope for filtering by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for filtering by user.
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('created_at', [$startDate, $endDate]);
    }

    /**
     * Log an activity.
     */
    public static function log($userId, $role, $action, $module, $recordId = null, $description = null, $ipAddress = null, $status = 'success')
    {
        return self::create([
            'user_id' => $userId,
            'role' => $role,
            'action' => $action,
            'module' => $module,
            'record_id' => $recordId,
            'description' => $description,
            'ip_address' => $ipAddress,
            'status' => $status,
        ]);
    }
}
