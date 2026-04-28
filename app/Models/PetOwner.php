<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $owner_id
 * @property int|null $address_id
 * @property int $user_id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $middle_name
 * @property string|null $suffix
 * @property string $phone_number
 * @property string|null $alternate_phone_number
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $date_of_birth
 * @property-read Address|null $address
 * @property-read Collection<int, Pet> $pets
 * @property-read int|null $pets_count
 * @property-read User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner active()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner whereAlternatePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner whereDateOfBirth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner whereOwnerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner whereSuffix($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|PetOwner whereUserId($value)
 *
 * @mixin \Eloquent
 */
class PetOwner extends Model
{
    protected $table = 'pet_owners';

    protected $primaryKey = 'owner_id';

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'middle_name',
        'suffix',
        'phone_number',
        'alternate_phone_number',
        'date_of_birth',
        'address_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function pets(): HasMany
    {
        return $this->hasMany(Pet::class, 'owner_id', 'owner_id');
    }

    public function vaccinationReports(): HasMany
    {
        return $this->hasMany(VaccinationReport::class, 'owner_id', 'owner_id');
    }

    public function spayNeuterReports(): HasMany
    {
        return $this->hasMany(SpayNeuterReport::class, 'owner_id', 'owner_id');
    }

    public function scopeActive($query)
    {
        return $query->whereHas('user', function ($q) {
            $q->where('status', 'active');
        });
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }
}
