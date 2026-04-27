<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string|null $pet_name
 * @property string|null $pet_breed
 * @property string|null $pet_age
 * @property string $owner_name
 * @property string|null $owner_contact
 * @property string|null $owner_address
 * @property string $procedure_type
 * @property string|null $veterinarian
 * @property string|null $clinic_name
 * @property numeric|null $weight
 * @property string $status
 * @property string|null $remarks
 * @property \Illuminate\Support\Carbon $report_date
 * @property string|null $barangay
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $gender
 * @property string|null $species
 * @property \Illuminate\Support\Carbon|null $scheduled_at
 * @property-read mixed $status_badge
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport byPetType($type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport byProcedureType($type)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport dateRange($startDate, $endDate)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereBarangay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereClinicName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereOwnerAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereOwnerContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereOwnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport wherePetAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport wherePetBreed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport wherePetName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereProcedureType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereReportDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereScheduledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereSpecies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereVeterinarian($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SpayNeuterReport whereWeight($value)
 * @mixin \Eloquent
 */
class SpayNeuterReport extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'spay_neuter_reports';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'pet_name',
        'species',
        'pet_breed',
        'pet_age',
        'gender',
        'owner_name',
        'owner_contact',
        'owner_address',
        'procedure_type',
        'scheduled_at',
        'veterinarian',
        'clinic_name',
        'weight',
        'status',
        'remarks',
        'report_date',
        'barangay',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'scheduled_at' => 'datetime',
            'report_date' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the user who created this report.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for filtering by procedure type.
     */
    public function scopeByProcedureType($query, $type)
    {
        return $query->where('procedure_type', $type);
    }

    /**
     * Scope for filtering by pet type.
     */
    public function scopeByPetType($query, $type)
    {
        return $query->where('species', $type);
    }

    /**
     * Scope for filtering by date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('scheduled_at', [$startDate, $endDate]);
    }

    /**
     * Get status badge color.
     */
    public function getStatusBadgeAttribute()
    {
        $colors = [
            'completed' => 'success',
            'scheduled' => 'info',
            'cancelled' => 'danger',
            'pending' => 'warning',
        ];

        return $colors[$this->status] ?? 'secondary';
    }
}
