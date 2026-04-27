<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $stray_report_id
 * @property int $barangay_id
 * @property int|null $reported_by_user_id
 * @property string $report_type
 * @property string $species
 * @property string|null $description
 * @property string|null $location_text
 * @property string|null $street_address
 * @property string|null $landmark
 * @property string|null $photo_path
 * @property string $urgency_level
 * @property string $report_status
 * @property \Illuminate\Support\Carbon $reported_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Barangay $barangay
 * @property-read \App\Models\ImpoundRecord|null $impoundRecord
 * @property-read \App\Models\User|null $reporter
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereLandmark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereLocationText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport wherePhotoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereReportStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereReportType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereReportedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereReportedByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereSpecies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereStrayReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereStreetAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StrayReport whereUrgencyLevel($value)
 * @mixin \Eloquent
 */
class StrayReport extends Model
{
    protected $primaryKey = 'stray_report_id';

    protected $fillable = [
        'barangay_id',
        'reported_by_user_id',
        'report_type',
        'species',
        'description',
        'location_text',
        'street_address',
        'landmark',
        'photo_path',
        'urgency_level',
        'report_status',
        'reported_at',
    ];

    protected $casts = [
        'reported_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    /**
     * Get the barangay this report belongs to.
     */
    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    /**
     * Get the user who reported.
     */
    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by_user_id');
    }

    /**
     * Get the impound record for this report.
     */
    public function impoundRecord(): HasOne
    {
        return $this->hasOne(ImpoundRecord::class, 'stray_report_id', 'stray_report_id');
    }

    /**
     * Get status badge color.
     */
    public function getStatusBadgeColor(): string
    {
        return match($this->report_status) {
            'new' => 'bg-danger',
            'validated' => 'bg-info',
            'responding' => 'bg-warning',
            'closed' => 'bg-success',
            default => 'bg-secondary',
        };
    }

    /**
     * Get urgency badge color.
     */
    public function getUrgencyBadgeColor(): string
    {
        return match($this->urgency_level) {
            'low' => 'bg-success',
            'medium' => 'bg-warning',
            'high' => 'bg-danger',
            default => 'bg-secondary',
        };
    }
}
