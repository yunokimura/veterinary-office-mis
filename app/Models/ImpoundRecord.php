<?php

namespace App\Models;

use App\Traits\HasStatusApproval;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @deprecated Scheduled for deletion 2026-05-24
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AdoptionRequest> $adoptionRequests
 * @property-read int|null $adoption_requests_count
 * @property-read \App\Models\User|null $approvedBy
 * @property-read \App\Models\Barangay|null $barangay
 * @property-read \App\Models\User|null $recordedBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ImpoundStatusHistory> $statusHistory
 * @property-read int|null $status_history_count
 * @property-read \App\Models\StrayReport|null $strayReport
 * @method static Builder<static>|ImpoundRecord approved()
 * @method static Builder<static>|ImpoundRecord closed()
 * @method static Builder<static>|ImpoundRecord impounded()
 * @method static Builder<static>|ImpoundRecord newModelQuery()
 * @method static Builder<static>|ImpoundRecord newQuery()
 * @method static Builder<static>|ImpoundRecord pending()
 * @method static Builder<static>|ImpoundRecord query()
 * @mixin \Eloquent
 */
class ImpoundRecord extends Model
{
    use HasStatusApproval;

    protected $table = 'impounds';

    protected $primaryKey = 'impound_id';

    protected $fillable = [
        'stray_report_id',
        'animal_type',
        'animal_name',
        'species',
        'breed',
        'color',
        'gender',
        'age',
        'owner_name',
        'owner_contact',
        'animal_tag_code',
        'intake_condition',
        'intake_location',
        'intake_date',
        'barangay_id',
        'current_disposition',
        'approved_by',
        'approved_at',
        'recorded_by',
    ];

    protected $casts = [
        'intake_date' => 'datetime',
        'approved_at' => 'datetime',
    ];

    public function strayReport(): BelongsTo
    {
        return $this->belongsTo(StrayReport::class, 'stray_report_id', 'stray_report_id');
    }

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by', 'id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by', 'id');
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(ImpoundStatusHistory::class, 'impound_id', 'impound_id');
    }

    public function adoptionRequests(): HasMany
    {
        return $this->hasMany(AdoptionRequest::class, 'impound_id', 'impound_id');
    }

    public function scopeImpounded(Builder $query): Builder
    {
        return $query->where('current_disposition', 'impounded');
    }
}
