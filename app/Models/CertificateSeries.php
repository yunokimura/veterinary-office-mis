<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $series_id
 * @property string $series_name
 * @property int $year
 * @property int $last_number
 * @property string $prefix
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateSeries newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateSeries newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateSeries query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateSeries whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateSeries whereLastNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateSeries wherePrefix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateSeries whereSeriesId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateSeries whereSeriesName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateSeries whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CertificateSeries whereYear($value)
 * @mixin \Eloquent
 */
class CertificateSeries extends Model
{
    use HasFactory;

    protected $fillable = [
        'series_name',
        'year',
        'last_number',
        'prefix',
    ];

    /**
     * Generate next certificate number for this series.
     */
    public function generateNumber(): string
    {
        $this->last_number = $this->last_number + 1;
        $this->save();

        return $this->formatNumber();
    }

    /**
     * Format the certificate number.
     */
    public function formatNumber(): string
    {
        return $this->prefix . '-' . $this->year . '-' . str_pad($this->last_number, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Get or create series for a given name and year.
     */
    public static function getOrCreate(string $seriesName, int $year, string $prefix): self
    {
        $series = self::where('series_name', $seriesName)
            ->where('year', $year)
            ->first();

        if (!$series) {
            $series = self::create([
                'series_name' => $seriesName,
                'year' => $year,
                'last_number' => 0,
                'prefix' => $prefix,
            ]);
        }

        return $series;
    }

    /**
     * Generate certificate number helper.
     */
    public static function generateCertificateNumber(string $seriesName, string $prefix): string
    {
        $year = date('Y');
        $series = self::getOrCreate($seriesName, $year, $prefix);
        return $series->generateNumber();
    }
}
