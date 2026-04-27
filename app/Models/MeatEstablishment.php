<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Barangay;

/**
 * @property int $establishment_id
 * @property string $establishment_name
 * @property string|null $establishment_type
 * @property string|null $owner_name
 * @property string|null $contact_person
 * @property string|null $contact_number
 * @property string|null $email
 * @property string $address_text
 * @property string|null $landmark
 * @property string|null $permit_no
 * @property string|null $inspection_date
 * @property int|null $barangay_id
 * @property int $registered_by_user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Barangay|null $barangay
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereAddressText($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereContactNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereContactPerson($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereEstablishmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereEstablishmentName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereEstablishmentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereInspectionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereLandmark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereOwnerName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment wherePermitNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereRegisteredByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatEstablishment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MeatEstablishment extends Model
{
    use HasFactory;

    protected $table = 'meat_establishments';
    protected $primaryKey = 'establishment_id';

    protected $fillable = [
        'establishment_name',
        'establishment_type',
        'owner_name',
        'contact_person',
        'contact_number',
        'email',
        'barangay_id',
        'address_text',
        'landmark',
        'permit_no',
        'registered_by_user_id',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registered_by_user_id');
    }

    public function barangay(): BelongsTo
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }
}
