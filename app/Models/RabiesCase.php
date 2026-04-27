<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 * @property \Illuminate\Support\Carbon $incident_date
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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $user_id
 * @property-read \App\Models\Barangay|null $barangay
 * @property-read \App\Models\Owner|null $owner
 * @property-read \App\Models\BiteRabiesReport|null $rabiesReport
 * @property-read \App\Models\User|null $user
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

    protected $table = 'bite_rabies_reports';

    protected $fillable = [
        'report_number',
        'patient_name',
        'age',
        'gender',
        'patient_address',
        'patient_contact',
        'barangay_id',
        'incident_date',
        'exposure_type',
        'bite_site',
        'category',
        'animal_type',
        'animal_status',
        'vaccination_status',
        'animal_owner_name',
        'animal_owner_contact',
        'reported_by',
        'user_id',
        'wound_management',
        'post_exposure_prophylaxis',
        'notes',
        'status',
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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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
