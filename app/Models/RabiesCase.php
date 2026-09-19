<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $status
 * @property string $report_number
 * @property int|null $patient_id
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
 * @property string|null $reporting_facility
 * @property string|null $date_reported
 * @property string|null $wound_management
 * @property string|null $post_exposure_prophylaxis
 * @property string|null $notes
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Barangay|null $barangay
 * @property-read \App\Models\Owner|null $owner
 * @property-read \App\Models\BiteRabiesReport|null $rabiesReport
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\Patient|null $patient
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereAnimalOwnerContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereAnimalOwnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereAnimalStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereAnimalType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereBiteSite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereDateReported($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereExactLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereExposureType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereIncidentBarangay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereIncidentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase wherePatientAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase wherePatientBarangay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase wherePatientContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase wherePatientFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase wherePatientMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase wherePatientName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase wherePatientSuffix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase wherePostExposureProphylaxis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereReportNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereReportedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereReportingFacility($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereVaccinationStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|RabiesCase whereWoundManagement($value)
 * @mixin \Eloquent
 */
class RabiesCase extends Model
{
    use HasFactory;

    protected $table = 'rabies_reports';

    protected $fillable = [
        'report_number',
        'status',
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
        'reporting_facility',
        'date_reported',
        'wound_management',
        'post_exposure_prophylaxis',
        'notes',
    ];

    protected $casts = [
        'incident_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function rabiesReport()
    {
        return $this->belongsTo(BiteRabiesReport::class, 'report_number', 'report_number');
    }

    public function owner()
    {
        return $this->belongsTo(Owner::class, 'animal_owner_name', 'owner_name');
    }

    public static function generateCaseNumber(): string
    {
        $year = date('Y');
        $lastCase = self::whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $nextNumber = $lastCase
            ? (int) substr($lastCase->report_number, -5) + 1
            : 1;

        return 'RAB-' . $year . '-' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }
}
