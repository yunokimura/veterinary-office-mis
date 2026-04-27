<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int|null $meat_shop_id
 * @property string|null $address
 * @property \Illuminate\Support\Carbon $inspection_date
 * @property string|null $ticket_number
 * @property string|null $licensing
 * @property string|null $storage
 * @property string|null $meat_quality
 * @property string|null $sanitation
 * @property string|null $lighting
 * @property string|null $personal_hygiene
 * @property string|null $equipment
 * @property string $apprehension_status
 * @property int|null $apprehended_by_user_id
 * @property string|null $remarks
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $inspector
 * @property-read \App\Models\MeatEstablishment|null $meatShop
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection byDate($date)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection byShop($shopId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereApprehendedByUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereApprehensionStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereEquipment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereInspectionDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereLicensing($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereLighting($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereMeatQuality($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereMeatShopId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection wherePersonalHygiene($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereSanitation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereStorage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereTicketNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|MeatShopInspection whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class MeatShopInspection extends Model
{
    use HasFactory;

    protected $table = 'meat_shop_inspections';

    protected $fillable = [
        'meat_shop_id',
        'address',
        'inspection_date',
        'ticket_number',
        'licensing',
        'storage',
        'meat_quality',
        'sanitation',
        'lighting',
        'personal_hygiene',
        'equipment',
        'apprehension_status',
        'apprehended_by_user_id',
        'remarks',
    ];

    protected $casts = [
        'inspection_date' => 'date',
    ];

    public function meatShop(): BelongsTo
    {
        return $this->belongsTo(MeatEstablishment::class, 'meat_shop_id', 'establishment_id');
    }

    public function inspector(): BelongsTo
    {
        return $this->belongsTo(User::class, 'apprehended_by_user_id');
    }

    public function scopeByDate($query, $date)
    {
        return $query->whereDate('inspection_date', $date);
    }

    public function scopeByShop($query, $shopId)
    {
        return $query->where('meat_shop_id', $shopId);
    }
}
