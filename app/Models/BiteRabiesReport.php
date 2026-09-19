<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $status
 * @property string $report_number
 * @property int|null $patient_id
 * @property string|null $report_source
 * @property string|null $assigned_to_role
 * @property string|null $reporting_facility
 * @property string|null $facility_name
 * @property Carbon|null $date_reported
 * @property int|null $barangay_id
 * @property Carbon $incident_date
 * @property string|null $exact_location
 * @property string $exposure_type
 * @property string|null $bite_site
 * @property string $category
 * @property string $animal_type
 * @property string $animal_status
 * @property string $vaccination_status
 * @property string|null $animal_owner_name
 * @property string|null $animal_owner_contact
 * @property int|null $reported_by
 * @property array<array-key, mixed>|null $wound_management
 * @property string|null $post_exposure_prophylaxis
 * @property string|null $notes
 * @property string|null $action_taken
 * @property bool $rabies_confirmed
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Barangay|null $barangay
 * @property-read Collection<int, Notification> $notifications
 * @property-read int|null $notifications_count
 * @property-read User|null $reportedBy
 * @property-read Patient|null $patient
 *
 * @method static Builder<static>|BiteRabiesReport newModelQuery()
 * @method static Builder<static>|BiteRabiesReport newQuery()
 * @method static Builder<static>|BiteRabiesReport query()
 * @method static Builder<static>|BiteRabiesReport whereAnimalOwnerContact($value)
 * @method static Builder<static>|BiteRabiesReport whereAnimalOwnerName($value)
 * @method static Builder<static>|BiteRabiesReport whereAnimalStatus($value)
 * @method static Builder<static>|BiteRabiesReport whereAnimalType($value)
 * @method static Builder<static>|BiteRabiesReport whereBarangayId($value)
 * @method static Builder<static>|BiteRabiesReport whereBiteSite($value)
 * @method static Builder<static>|BiteRabiesReport whereCategory($value)
 * @method static Builder<static>|BiteRabiesReport whereCreatedAt($value)
 * @method static Builder<static>|BiteRabiesReport whereDateReported($value)
 * @method static Builder<static>|BiteRabiesReport whereExactLocation($value)
 * @method static Builder<static>|BiteRabiesReport whereExposureType($value)
 * @method static Builder<static>|BiteRabiesReport whereId($value)
 * @method static Builder<static>|BiteRabiesReport whereNotes($value)
 * @method static Builder<static>|BiteRabiesReport wherePatientId($value)
 * @method static Builder<static>|BiteRabiesReport wherePostExposureProphylaxis($value)
 * @method static Builder<static>|BiteRabiesReport whereRabiesConfirmed($value)
 * @method static Builder<static>|BiteRabiesReport whereReportNumber($value)
 * @method static Builder<static>|BiteRabiesReport whereReportedBy($value)
 * @method static Builder<static>|BiteRabiesReport whereReportingFacility($value)
 * @method static Builder<static>|BiteRabiesReport whereStatus($value)
 * @method static Builder<static>|BiteRabiesReport whereUpdatedAt($value)
 * @method static Builder<static>|BiteRabiesReport whereVaccinationStatus($value)
 * @method static Builder<static>|BiteRabiesReport whereWoundManagement($value)
 *
 * @mixin \Eloquent
 */
class BiteRabiesReport extends Model
{
    protected $table = 'rabies_reports';

    protected $fillable = [
        'report_number',
        'status',
        'report_source',
        'assigned_to_role',
        'reporting_facility',
        'facility_name',
        'date_reported',
        'patient_id',
        'barangay_id',
        'incident_date',
        'exact_location',
        'exposure_type',
        'bite_site',
        'category',
        'animal_type',
        'animal_status',
        'vaccination_status',
        'animal_owner_name',
        'animal_owner_contact',
        'reported_by',
        'wound_management',
        'post_exposure_prophylaxis',
        'notes',
        'action_taken',
        'rabies_confirmed',
    ];

    protected $casts = [
        'incident_date' => 'date',
        'date_reported' => 'date',
        'wound_management' => 'array',
    ];

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function reportedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by', 'id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class, 'reference_id')
            ->where('module', 'bite_rabies_report');
    }

    public function scopeByBarangay(Builder $query, int $barangayId): Builder
    {
        return $query->where('barangay_id', $barangayId);
    }

    public function scopeByCategory(Builder $query, string $category): Builder
    {
        return $query->where('category', $category);
    }

    public function scopeByAnimalType(Builder $query, string $type): Builder
    {
        return $query->where('animal_type', $type);
    }

    public function scopeByDateRange(Builder $query, string $from, string $to): Builder
    {
        return $query->whereBetween('incident_date', [$from, $to]);
    }

    public static function generateReportNumber(): string
    {
        $year = date('Y');
        $lastReport = self::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastReport
            ? (int) substr($lastReport->report_number, -5) + 1
            : 1;

        return 'BR-'.$year.'-'.str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }
}
