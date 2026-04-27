<?php

namespace App\Models;

use App\Traits\HasStatusApproval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

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
 * @property \Illuminate\Support\Carbon|null $approved_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $approvedBy
 * @property-read \App\Models\MeatEstablishment|null $establishment
 * @property-read \App\Models\User|null $inspector
 * @method static Builder<static>|MeatInspection approved()
 * @method static Builder<static>|MeatInspection closed()
 * @method static Builder<static>|MeatInspection failed()
 * @method static Builder<static>|MeatInspection newModelQuery()
 * @method static Builder<static>|MeatInspection newQuery()
 * @method static Builder<static>|MeatInspection passed()
 * @method static Builder<static>|MeatInspection pending()
 * @method static Builder<static>|MeatInspection query()
 * @method static Builder<static>|MeatInspection whereApprovedAt($value)
 * @method static Builder<static>|MeatInspection whereApprovedBy($value)
 * @method static Builder<static>|MeatInspection whereComplianceStatus($value)
 * @method static Builder<static>|MeatInspection whereCreatedAt($value)
 * @method static Builder<static>|MeatInspection whereEstablishmentId($value)
 * @method static Builder<static>|MeatInspection whereFindings($value)
 * @method static Builder<static>|MeatInspection whereInspectionDate($value)
 * @method static Builder<static>|MeatInspection whereInspectionId($value)
 * @method static Builder<static>|MeatInspection whereInspectionType($value)
 * @method static Builder<static>|MeatInspection whereInspectorName($value)
 * @method static Builder<static>|MeatInspection whereInspectorUserId($value)
 * @method static Builder<static>|MeatInspection whereObservations($value)
 * @method static Builder<static>|MeatInspection whereOverallRating($value)
 * @method static Builder<static>|MeatInspection whereRecommendations($value)
 * @method static Builder<static>|MeatInspection whereRemarks($value)
 * @method static Builder<static>|MeatInspection whereStatus($value)
 * @method static Builder<static>|MeatInspection whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MeatInspection extends Model
{
    use HasStatusApproval;

    protected $table = 'meat_inspections';
    protected $primaryKey = 'inspection_id';

    protected $fillable = [
        'establishment_id',
        'inspector_user_id',
        'inspection_date',
        'findings',
        'status',
        'compliance_status',
        'remarks',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'inspection_date' => 'date',
        'approved_at' => 'datetime',
    ];

    public function establishment(): BelongsTo
    {
        return $this->belongsTo(MeatEstablishment::class, 'establishment_id');
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inspector_user_id', 'id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->whereNotNull('approved_by');
    }

    public function scopePending(Builder $query): Builder
    {
        return $query->whereNull('approved_by');
    }

    public function scopePassed(Builder $query): Builder
    {
        return $query->where('status', 'passed');
    }

    public function scopeFailed(Builder $query): Builder
    {
        return $query->where('status', 'failed');
    }
}