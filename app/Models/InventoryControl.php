<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $item_name
 * @property string $category
 * @property string|null $unit
 * @property int $quantity
 * @property int $minimum_stock
 * @property numeric|null $unit_price
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $expiry_date
 * @property int|null $barangay_id
 * @property string $status
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Barangay|null $barangay
 * @property-read \App\Models\User|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StockMovement> $movements
 * @property-read int|null $movements_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereItemName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereMinimumStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InventoryControl extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'category',
        'unit',
        'quantity',
        'minimum_stock',
        'unit_price',
        'description',
        'expiry_date',
        'barangay_id',
        'status',
        'created_by',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'quantity' => 'integer',
        'minimum_stock' => 'integer',
        'unit_price' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function barangay()
    {
        return $this->belongsTo(Barangay::class, 'barangay_id', 'barangay_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function movements()
    {
        return $this->hasMany(StockMovement::class, 'inventory_item_id');
    }

    public function isLowStock()
    {
        return $this->quantity <= $this->minimum_stock;
    }
}
