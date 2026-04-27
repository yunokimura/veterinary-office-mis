<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $report_id
 * @property int $user_id
 * @property int $pet_id
 * @property string|null $body_marks
 * @property string $eye_color
 * @property string|null $collar_harness
 * @property \Illuminate\Support\Carbon $last_seen_at
 * @property string $location_barangay
 * @property string|null $location_description
 * @property string|null $emergency_contact
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pet $pet
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereBodyMarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereCollarHarness($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereEmergencyContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereEyeColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereLastSeenAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereLocationBarangay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereLocationDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport wherePetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereUserId($value)
 * @mixin \Eloquent
 */
class MissingPetsReport extends Model
{
    protected $table = 'missing_pets_reports';
    protected $primaryKey = 'report_id';

    protected $fillable = [
        'user_id',
        'pet_id',
        'body_marks',
        'eye_color',
        'collar_harness',
        'last_seen_at',
        'location_barangay',
        'location_description',
        'emergency_contact',
        'status',
    ];

    protected $casts = [
        'last_seen_at' => 'datetime',
    ];

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class, 'pet_id', 'pet_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}