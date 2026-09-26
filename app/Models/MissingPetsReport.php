<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $report_id
 * @property int|null $user_id
 * @property int|null $pet_id
 * @property string|null $report_type
 * @property string|null $reported_by_name
 * @property string|null $reporter_contact
 * @property string|null $reporter_email
 * @property string|null $photo_path
 * @property string|null $body_marks
 * @property string $eye_color
 * @property string|null $collar_harness
 * @property \Illuminate\Support\Carbon $last_seen_at
 * @property int|null $barangay_id
 * @property string|null $location_description
 * @property string|null $emergency_contact
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pet|null $pet
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\Barangay|null $barangay
 * @property-read string $reporter_display_name
 * @property-read string|null $reporter_contact
 * @property-read string|null $reporter_email
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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport wherePetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereReportId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereReportType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereReporterContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereReporterEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MissingPetsReport whereReportedByName($value)
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
        'report_type',
        'reported_by_name',
        'reporter_contact',
        'reporter_email',
        'photo_path',
        'body_marks',
        'eye_color',
        'collar_harness',
        'last_seen_at',
        'barangay_id',
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

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    public function getReporterDisplayNameAttribute(): string
    {
        return $this->reported_by_name ?? $this->user?->contact_number ?? 'N/A';
    }

    public function getReporterContactAttribute(): ?string
    {
        return $this->attributes['reporter_contact'] ?? $this->user?->contact_number ?? null;
    }

    public function getReporterEmailAttribute(): ?string
    {
        return $this->attributes['reporter_email'] ?? $this->user?->email ?? null;
    }
}