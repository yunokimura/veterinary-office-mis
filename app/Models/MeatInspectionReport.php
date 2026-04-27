<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $inspection_id
 * @property int|null $establishment_id
 * @property int|null $inspector_user_id
 * @property string|null $inspector_name
 * @property string|null $inspection_type
 * @property \Illuminate\Support\Carbon $inspection_date
 * @property string $status
 * @property string|null $compliance_status
 * @property string|null $findings
 * @property string|null $observations
 * @property string|null $recommendations
 * @property string|null $overall_rating
 * @property string|null $remarks
 * @property int|null $approved_by
 * @property string|null $approved_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property mixed $inspection_time
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport compliant()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport nonCompliant()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereApprovedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereComplianceStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereEstablishmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereFindings($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereInspectionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereInspectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereInspectionType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereInspectorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereInspectorUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereObservations($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereOverallRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereRecommendations($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatInspectionReport whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MeatInspectionReport extends Model
{
    use HasFactory;
    protected $table = 'meat_inspections';

    protected $fillable = [
        'inspector_user_id',
        'establishment_name',
        'establishment_type',
        'establishment_address',
        'owner_name',
        'owner_contact',
        'inspection_date',
        'inspection_time',
        'inspector_name',
        'inspection_type',
        'overall_rating',
        'findings',
        'observations',
        'recommendations',
        'compliance_status',
        'penalty_imposed',
        'next_inspection_date',
        'attachments',
        'notes',
    ];

    protected $casts = [
        'inspection_date' => 'date',
        'inspection_time' => 'time',
        'next_inspection_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'inspector_user_id');
    }

    public function scopeCompliant($query)
    {
        return $query->where('compliance_status', 'compliant');
    }

    public function scopeNonCompliant($query)
    {
        return $query->where('compliance_status', 'non_compliant');
    }
}
