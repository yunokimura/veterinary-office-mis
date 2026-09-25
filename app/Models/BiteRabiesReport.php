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
 * @property string $report_number
 * @property string|null $report_source
 * @property string|null $assigned_to_role
 * @property string|null $facility_name
 * @property Carbon|null $date_reported
 * @property int|null $barangay_id
 * @property Carbon $incident_date
 * @property string|null $exact_location
 * @property string $animal_type
 * @property string $animal_status
 * @property string|null $animal_name
 * @property string|null $animal_gender
 * @property string $vaccination_status
 * @property string|null $animal_owner_name
 * @property string|null $animal_owner_contact
 * @property array<array-key, mixed>|null $wound_management
 * @property string|null $post_exposure_prophylaxis
 * @property string|null $notes
 * @property string|null $action_taken
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Barangay|null $barangay
 * @property-read Collection<int, Notification> $notifications
 * @property-read int|null $notifications_count
 *
 * @method static Builder<static>|BiteRabiesReport newModelQuery()
 * @method static Builder<static>|BiteRabiesReport newQuery()
 * @method static Builder<static>|BiteRabiesReport query()
 * @method static Builder<static>|BiteRabiesReport whereAnimalOwnerContact($value)
 * @method static Builder<static>|BiteRabiesReport whereAnimalOwnerName($value)
 * @method static Builder<static>|BiteRabiesReport whereAnimalStatus($value)
 * @method static Builder<static>|BiteRabiesReport whereAnimalType($value)
 * @method static Builder<static>|BiteRabiesReport whereAnimalGender($value)
 * @method static Builder<static>|BiteRabiesReport whereBarangayId($value)
 * @method static Builder<static>|BiteRabiesReport whereBiteSite($value)
 * @method static Builder<static>|BiteRabiesReport whereCreatedAt($value)
 * @method static Builder<static>|BiteRabiesReport whereDateReported($value)
 * @method static Builder<static>|BiteRabiesReport whereExactLocation($value)
 * @method static Builder<static>|BiteRabiesReport whereId($value)
 * @method static Builder<static>|BiteRabiesReport whereNotes($value)
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
        'date_reported',
        'barangay_id',
        'incident_date',
        'exact_location',
        'animal_type',
        'animal_gender',
        'animal_status',
        'animal_name',
        'vaccination_status',
        'animal_owner_name',
        'animal_owner_contact',
        'notes',
        'action_taken',
    ];

    protected $casts = [
        'incident_date' => 'date',
        'date_reported' => 'date',
    ];

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
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

    public function scopeByAnimalType(Builder $query, string $type): Builder
    {
        return $query->where('animal_type', $type);
    }

    public function scopeByAnimalGender(Builder $query, string $gender): Builder
    {
        return $query->where('animal_gender', $gender);
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
