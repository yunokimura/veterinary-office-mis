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
 * @property string $patient_name
 * @property string|null $patient_first_name
 * @property string|null $patient_middle_name
 * @property string|null $patient_suffix
 * @property int $age
 * @property string $gender
 * @property string|null $patient_address
 * @property string|null $patient_contact
 * @property string|null $patient_barangay
 * @property int|null $barangay_id
 * @property string|null $incident_barangay
 * @property string|null $exact_location
 * @property Carbon $incident_date
 * @property string $exposure_type
 * @property string|null $bite_site
 * @property string $category
 * @property string $animal_type
 * @property string $animal_status
 * @property string $vaccination_status
 * @property string|null $animal_owner_name
 * @property string|null $animal_owner_contact
 * @property int|null $reported_by
 * @property string|null $reporting_facility
 * @property string|null $date_reported
 * @property array<array-key, mixed>|null $wound_management
 * @property string|null $post_exposure_prophylaxis
 * @property string|null $notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property int|null $user_id
 * @property-read Barangay|null $barangay
 * @property-read Collection<int, Notification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Barangay|null $patientBarangay
 * @property-read User|null $reportedBy
 *
 * @method static Builder<static>|BiteRabiesReport byAnimalType(string $type)
 * @method static Builder<static>|BiteRabiesReport byBarangay(int $barangayId)
 * @method static Builder<static>|BiteRabiesReport byCategory(string $category)
 * @method static Builder<static>|BiteRabiesReport byDateRange(string $from, string $to)
 * @method static Builder<static>|BiteRabiesReport newModelQuery()
 * @method static Builder<static>|BiteRabiesReport newQuery()
 * @method static Builder<static>|BiteRabiesReport query()
 * @method static Builder<static>|BiteRabiesReport whereAge($value)
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
 * @method static Builder<static>|BiteRabiesReport whereGender($value)
 * @method static Builder<static>|BiteRabiesReport whereId($value)
 * @method static Builder<static>|BiteRabiesReport whereIncidentBarangay($value)
 * @method static Builder<static>|BiteRabiesReport whereIncidentDate($value)
 * @method static Builder<static>|BiteRabiesReport whereNotes($value)
 * @method static Builder<static>|BiteRabiesReport wherePatientAddress($value)
 * @method static Builder<static>|BiteRabiesReport wherePatientBarangay($value)
 * @method static Builder<static>|BiteRabiesReport wherePatientContact($value)
 * @method static Builder<static>|BiteRabiesReport wherePatientFirstName($value)
 * @method static Builder<static>|BiteRabiesReport wherePatientMiddleName($value)
 * @method static Builder<static>|BiteRabiesReport wherePatientName($value)
 * @method static Builder<static>|BiteRabiesReport wherePatientSuffix($value)
 * @method static Builder<static>|BiteRabiesReport wherePostExposureProphylaxis($value)
 * @method static Builder<static>|BiteRabiesReport whereReportNumber($value)
 * @method static Builder<static>|BiteRabiesReport whereReportedBy($value)
 * @method static Builder<static>|BiteRabiesReport whereReportingFacility($value)
 * @method static Builder<static>|BiteRabiesReport whereStatus($value)
 * @method static Builder<static>|BiteRabiesReport whereUpdatedAt($value)
 * @method static Builder<static>|BiteRabiesReport whereUserId($value)
 * @method static Builder<static>|BiteRabiesReport whereVaccinationStatus($value)
 * @method static Builder<static>|BiteRabiesReport whereWoundManagement($value)
 *
 * @mixin \Eloquent
 */
class BiteRabiesReport extends Model
{
    protected $table = 'bite_rabies_reports';

    protected $fillable = [
        'report_number',
        'status',
        'report_source',
        'assigned_to_role',
        'reporting_facility',
        'facility_name',
        'date_reported',
        'patient_name',
        'patient_age',
        'patient_gender',
        'patient_barangay_id',
        'patient_contact',
        'incident_date',
        'nature_of_incident',
        'exposure_category',
        'animal_species',
        'animal_current_condition',
        'animal_vaccination_status',
        // Standard fields
        'patient_first_name',
        'patient_middle_name',
        'patient_suffix',
        'age',
        'gender',
        'patient_address',
        'patient_barangay',
        'barangay_id',
        'incident_barangay',
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
    ];

    protected $casts = [
        'incident_date' => 'date',
        'wound_management' => 'array',
    ];

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    public function patientBarangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'patient_barangay', 'barangay_name', 'barangay_name');
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
