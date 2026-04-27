<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $barangay_id
 * @property string $barangay_name
 * @property string $city
 * @property string $province
 * @property float|null $latitude
 * @property float|null $longitude
 * @property string|null $contact_number
 * @property string|null $office_email
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BiteRabiesReport> $biteRabiesReports
 * @property-read int|null $bite_rabies_reports_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ClinicalAction> $clinicalActions
 * @property-read int|null $clinical_actions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Establishment> $establishments
 * @property-read int|null $establishments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Livestock> $livestock
 * @property-read int|null $livestock_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\LivestockCensus> $livestockCensuses
 * @property-read int|null $livestock_censuses_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StrayReport> $strayReports
 * @property-read int|null $stray_reports_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereBarangayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereOfficeEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereProvince($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Barangay whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Barangay extends Model
{
    protected $primaryKey = 'barangay_id';
    protected $table = 'barangays';

    protected $fillable = [
        'barangay_name',
        'city',
        'province',
        'latitude',
        'longitude',
        'contact_number',
        'office_email',
        'status',
    ];

    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
        'created_at' => 'datetime',
    ];

    public function biteRabiesReports(): HasMany
    {
        return $this->hasMany(BiteRabiesReport::class, 'barangay_id', 'barangay_id');
    }

    public function livestock(): HasMany
    {
        return $this->hasMany(Livestock::class, 'barangay_id', 'barangay_id');
    }

    public function establishments(): HasMany
    {
        return $this->hasMany(Establishment::class, 'barangay_id', 'barangay_id');
    }

    public function strayReports(): HasMany
    {
        return $this->hasMany(StrayReport::class, 'barangay_id', 'barangay_id');
    }

    public function livestockCensuses(): HasMany
    {
        return $this->hasMany(LivestockCensus::class, 'barangay_id', 'barangay_id');
    }

    public function clinicalActions(): HasMany
    {
        return $this->hasMany(ClinicalAction::class, 'barangay_id', 'barangay_id');
    }
}
