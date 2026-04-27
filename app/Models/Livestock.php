<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $livestock_id
 * @property int|null $owner_id
 * @property string|null $farm_name
 * @property string|null $animal_type
 * @property int $quantity
 * @property int|null $barangay_id
 * @property string $species
 * @property string|null $breed
 * @property string|null $color
 * @property string $gender
 * @property int|null $age
 * @property string $age_unit
 * @property string|null $tag_number
 * @property string|null $owner_name
 * @property string|null $owner_contact
 * @property string|null $address
 * @property string $status
 * @property string|null $notes
 * @property int|null $recorded_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Barangay|null $barangay
 * @property-read \App\Models\PetOwner|null $owner
 * @property-read \App\Models\User|null $recordedBy
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereAge($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereAgeUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereAnimalType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereBreed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereFarmName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereLivestockId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereOwnerContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereOwnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereRecordedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereSpecies($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereTagNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Livestock whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Livestock extends Model
{
    protected $table = 'livestock';
    protected $primaryKey = 'livestock_id';

    protected $fillable = [
        'owner_id',
        'barangay_id',
        'species',
        'breed',
        'color',
        'gender',
        'age',
        'age_unit',
        'tag_number',
        'owner_name',
        'owner_contact',
        'address',
        'status',
        'notes',
        'recorded_by',
    ];

    protected $casts = [
        'age' => 'integer',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(PetOwner::class, 'owner_id', 'owner_id');
    }

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by', 'id');
    }
}
