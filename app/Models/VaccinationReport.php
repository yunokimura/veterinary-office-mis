<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int|null $appointment_id
 * @property string $owner_first_name
 * @property string $owner_last_name
 * @property string $owner_email
 * @property string $owner_contact
 * @property string|null $alt_mobile_number
 * @property string $blk_lot_ph
 * @property string $street
 * @property string $barangay
 * @property \Illuminate\Support\Carbon $scheduled_at
 * @property \Illuminate\Support\Carbon|null $last_anti_rabies_date
 * @property bool $recent_surgery
 * @property string $status
 * @property array<array-key, mixed>|null $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read array $selected_pets
 * @property-read string $status_badge
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereAltMobileNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereAppointmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereBarangay($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereBlkLotPh($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereLastAntiRabiesDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereOwnerContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereOwnerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereOwnerFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereOwnerLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereRecentSurgery($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereScheduledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereStreet($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereUserId($value)
 * @mixin \Eloquent
 */
class VaccinationReport extends Model
{
    protected $table = 'vaccination_reports';

    protected $fillable = [
        'user_id',
        'appointment_id',
        'owner_first_name',
        'owner_last_name',
        'owner_email',
        'owner_contact',
        'alt_mobile_number',
        'blk_lot_ph',
        'street',
        'barangay',
        'scheduled_at',
        'last_anti_rabies_date',
        'recent_surgery',
        'status',
        'metadata',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'last_anti_rabies_date' => 'date',
        'recent_surgery' => 'boolean',
        'metadata' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getSelectedPetsAttribute(): array
    {
        return $this->metadata['selected_pets'] ?? [];
    }

    public function getStatusBadgeAttribute(): string
    {
        $colors = [
            'pending' => 'warning',
            'approved' => 'info',
            'completed' => 'success',
            'cancelled' => 'danger',
            'no_show' => 'secondary',
        ];
        return $colors[$this->status] ?? 'secondary';
    }
}