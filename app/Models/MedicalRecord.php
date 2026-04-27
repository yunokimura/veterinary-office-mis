<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $user_id
 * @property int $owner_id
 * @property string $type
 * @property string|null $appointment_date
 * @property string $status
 * @property string|null $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Barangay|null $barangay
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\Pet|null $pet
 * @property-read \App\Models\User|null $veterinarian
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalRecord newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalRecord newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalRecord query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalRecord whereAppointmentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalRecord whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalRecord whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalRecord whereMetadata($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalRecord whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalRecord whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalRecord whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalRecord whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MedicalRecord whereUserId($value)
 * @mixin \Eloquent
 */
class MedicalRecord extends Model
{
    protected $table = 'medical_records';

    protected $fillable = [
        'pet_id',
        'barangay_id',
        'diagnosis',
        'treatment',
        'veterinarian_id',
        'created_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function pet(): BelongsTo
    {
        return $this->belongsTo(Pet::class, 'pet_id');
    }

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    public function veterinarian(): BelongsTo
    {
        return $this->belongsTo(User::class, 'veterinarian_id', 'id');
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}