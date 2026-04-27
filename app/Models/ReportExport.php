<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $report_type
 * @property array<array-key, mixed>|null $parameters
 * @property string|null $file_path
 * @property int|null $exported_by_user_id
 * @property \Illuminate\Support\Carbon $exported_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportExport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportExport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportExport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportExport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportExport whereExportedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportExport whereExportedByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportExport whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportExport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportExport whereParameters($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportExport whereReportType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ReportExport whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ReportExport extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'report_exports';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'report_type',
        'parameters',
        'file_path',
        'exported_by_user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'parameters' => 'array',
            'exported_at' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the user who exported the report.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'exported_by_user_id');
    }
}
