<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property int|null $owner_id
 * @property int|null $appointment_id
 * @property int|null $address_id
 * @property Carbon $scheduled_at
 * @property Carbon|null $last_anti_rabies_date
 * @property bool $recent_surgery
 * @property string $status
 * @property array<array-key, mixed>|null $metadata
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read array $selected_pets
 * @property-read string $status_badge
 * @property-read User $user
 * @property-read PetOwner|null $owner
 * @property-read Address|null $address
 * @property-read string $owner_name
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereAltMobileNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereAppointmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereLastAntiRabiesDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereOwnerContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereOwnerEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereOwnerFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereOwnerLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereRecentSurgery($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereScheduledAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|VaccinationReport whereUserId($value)
 *
 * @mixin \Eloquent
 */
class VaccinationReport extends Model
{
    protected $table = 'vaccination_reports';

    protected $fillable = [
        'user_id',
        'owner_id',
        'appointment_id',
        'address_id',
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

    public function owner(): BelongsTo
    {
        return $this->belongsTo(PetOwner::class, 'owner_id', 'owner_id');
    }

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function rabiesVaccinationReport(): HasOne
    {
        return $this->hasOne(RabiesVaccinationReport::class, 'vaccination_report_id');
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

    public function getOwnerNameAttribute(): string
    {
        return $this->owner ? trim($this->owner->first_name.' '.$this->owner->last_name) : 'N/A';
    }
}
