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

    protected $primaryKey = 'id';
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

    public function getActionInPastTenseAttribute(): string
    {
        return match (strtolower($this->action)) {
            'create' => 'created',
            'update' => 'updated',
            'delete' => 'deleted',
            'login' => 'logged in',
            'logout' => 'logged out',
            default => $this->action,
        };
    }

    public function getActionDisplayAttribute(): string
    {
        $action = strtolower($this->action ?? '');

        $map = [
            'toggle_user_status' => 'Toggle Status',
        ];

        return $map[$action] ?? ucfirst(str_replace('_', ' ', $this->action));
    }

    public function getModuleDisplayAttribute(): string
    {
        $module = $this->module ?? '-';

        $map = [
            'Authentication' => 'Auth',
            'User Management' => 'Users',
            'roles' => 'Role Management',
            'system-logs' => 'System Logs',
            'settings' => 'System Settings',
            'stats' => 'Statistics',
            'user-stats' => 'Statistics',
            'system-activity' => 'Statistics',
            'export' => 'Export',
            'activity-logs' => 'Activity Logs',
            'all-reports' => 'Reports',
            'animal-bite-reports' => 'Animal Bite Reports',
            'bite-rabies-reports' => 'Bite & Rabies Reports',
            'vaccination-reports' => 'Vaccination Reports',
            'meat-inspection-reports' => 'Meat Inspection Reports',
            'vaccination-appointments' => 'Vaccination Appointments',
            'missing-pet-reports' => 'Missing Pet Reports',
            'adoption-reports' => 'Adoption Reports',
            'announcements' => 'Announcements',
            'notifications' => 'Notifications',
            'pet-registrations' => 'Pet Registrations',
            'adoption-applications' => 'Adoption Applications',
            'missing-pets' => 'Missing Pets',
            'owners' => 'Pet Owners',
            'appointments' => 'Appointments',
            'business-profiles' => 'Business Profiles',
            'inventory' => 'Inventory',
            'medical-records' => 'Medical Records',
            'vaccinations' => 'Vaccinations',
            'spay-neuter' => 'Spay/Neuter',
            'rabies-cases' => 'Rabies Cases',
            'rabies-geomap' => 'Rabies Geomap',
            'meat-inspection' => 'Meat Inspection',
            'reports' => 'Meat Inspection Reports',
            'meat-shop' => 'Meat Shop Inspections',
            'establishments' => 'Meat Establishments',
            'establishments-overview' => 'Meat Establishments Overview',
            'device-tokens' => 'Device Tokens',
            'kapon' => 'Kapon Program',
        ];

        return $map[$module] ?? ucfirst(str_replace('_', ' ', $module));
    }

    public function getActivityTextAttribute(): string
    {
        $name = $this->user->name ?? 'System';
        $boldName = "<strong>{$name}</strong>";

        return match (strtolower($this->action)) {
            'login', 'logout' => "{$boldName} {$this->action_in_past_tense}",
            'register' => "{$boldName} registered",
            'address_fallback' => "{$boldName} triggered a barangay fallback",
            'create_user' => "{$boldName} created a user",
            'update_user' => "{$boldName} updated a user",
            'delete_user' => "{$boldName} deleted a user",
            'toggle_user_status' => "{$boldName} changed a user status",
            'export_report' => "{$boldName} exported a report",
            'update_settings' => "{$boldName} updated system settings",
            default => $this->defaultActivityText($boldName),
        };
    }

    private function defaultActivityText(string $boldName): string
    {
        $action = $this->action_in_past_tense;
        $module = $this->module;

        if (stripos($module ?? '', 'pet') === 0 && strtolower($this->action) === 'create') {
            return "{$boldName} registered a {$module}";
        }

        return $module ? "{$boldName} {$action} in {$module}" : "{$boldName} {$action}";
    }

    public function getStatusColorAttribute(): string
    {
        $action = strtolower($this->action ?? '');
        $status = strtolower($this->status ?? '');

        if ($status === 'failed' || $action === 'delete' || $action === 'delete_user') {
            return 'bg-red-500';
        }

        if (in_array($action, ['create', 'update', 'create_user', 'update_user'])) {
            return 'bg-blue-500';
        }

        return 'bg-green-500';
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
     * Scope for flexible search across IP, user names, and date/time.
     */
    public function scopeSearch($query, string $search)
    {
        if (!trim($search)) {
            return $query;
        }

        $terms = \App\Helpers\LogSearchParser::parseSearchTerms($search);

        foreach ($terms['textTerms'] as $term) {
            $query->where(function ($q) use ($term) {
                $q->where('ip_address', 'like', "%{$term}%")
                    ->orWhereIn('user_id', function ($sub) use ($term) {
                        $sub->select('user_id')
                            ->from('admins')
                            ->where(function ($s) use ($term) {
                                $s->whereRaw("CONCAT_WS(' ', first_name, middle_name, last_name) LIKE ?", ["%{$term}%"])
                                  ->orWhereRaw("CONCAT_WS(' ', first_name, last_name) LIKE ?", ["%{$term}%"]);
                            });
                    })
                    ->orWhereIn('user_id', function ($sub) use ($term) {
                        $sub->select('user_id')
                            ->from('pet_owners')
                            ->where(function ($s) use ($term) {
                                $s->whereRaw("CONCAT_WS(' ', first_name, middle_name, last_name) LIKE ?", ["%{$term}%"])
                                  ->orWhereRaw("CONCAT_WS(' ', first_name, last_name) LIKE ?", ["%{$term}%"]);
                            });
                    });
            });
        }

        foreach ($terms['dateTerms'] as $dateTerm) {
            switch ($dateTerm['type']) {
                case 'year':
                    $query->whereYear('created_at', $dateTerm['value']->year);
                    break;
                case 'date':
                    $query->whereDate('created_at', $dateTerm['date']->toDateString());
                    break;
                case 'datetime':
                    $start = $dateTerm['value']->copy()->startOfMinute();
                    $end = $dateTerm['value']->copy()->endOfMinute();
                    $query->whereBetween('created_at', [$start, $end]);
                    break;
            }
        }

        return $query;
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
