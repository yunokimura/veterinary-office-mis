<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $barangay_id
 * @property int|null $encoded_by_user_id
 * @property string $species
 * @property int $no_of_heads
 * @property int $no_of_farmers
 * @property string $report_year
 * @property int $report_month
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Barangay|null $barangay
 * @property-read mixed $species_badge
 * @property-read mixed $species_name
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus whereEncodedByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus whereNoOfFarmers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus whereNoOfHeads($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus whereReportMonth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus whereReportYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus whereSpecies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LivestockCensus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LivestockCensus extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'livestock_censuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'barangay_id',
        'species',
        'no_of_heads',
        'no_of_farmers',
        'report_year',
        'report_month',
        'encoded_by_user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the barangay.
     */
    public function barangay()
    {
        return $this->belongsTo(Barangay::class);
    }

    /**
     * Get the user who encoded this census.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'encoded_by_user_id');
    }

    /**
     * Get species badge.
     */
    public function getSpeciesBadgeAttribute()
    {
        $badges = [
            'cattle' => 'primary',
            'carabao' => 'info',
            'swine' => 'warning',
            'horse' => 'success',
            'goat' => 'secondary',
            'dog' => 'danger',
            'pigeon' => 'dark',
        ];

        return $badges[$this->species] ?? 'secondary';
    }

    /**
     * Get formatted species name.
     */
    public function getSpeciesNameAttribute()
    {
        return ucfirst($this->species);
    }
}
