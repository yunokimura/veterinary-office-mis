<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $item_name
 * @property string|null $item_code
 * @property string $category
 * @property string|null $unit
 * @property int $quantity
 * @property int $minimum_stock
 * @property numeric|null $unit_cost
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $expiry_date
 * @property string|null $batch_number
 * @property string|null $supplier
 * @property string|null $storage_location
 * @property string $status
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $createdBy
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\InventoryMovement> $movements
 * @property-read int|null $movements_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl byCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl byItemCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl expired()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl expiringSoon($days = 30)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl lowStock()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereBatchNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereExpiryDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereItemCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereItemName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereMinimumStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereStorageLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereSupplier($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereUnitCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryControl whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InventoryControl extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_name',
        'item_code',
        'category',
        'unit',
        'quantity',
        'minimum_stock',
        'unit_cost',
        'description',
        'expiry_date',
        'batch_number',
        'supplier',
        'storage_location',
        'status',
        'created_by',
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'quantity' => 'integer',
        'minimum_stock' => 'integer',
        'unit_cost' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function movements()
    {
        return $this->hasMany(InventoryMovement::class, 'inventory_control_id');
    }

    public function isLowStock()
    {
        return $this->quantity <= $this->minimum_stock;
    }

    public function scopeByCategory($query, $value)
    {
        return $query->where('category', $value);
    }

    public function scopeLowStock($query)
    {
        return $query->whereRaw('quantity <= minimum_stock');
    }

    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->whereNotNull('expiry_date')
            ->where('expiry_date', '<=', now()->addDays($days))
            ->where('expiry_date', '>=', now());
    }

    public function scopeExpired($query)
    {
        return $query->whereNotNull('expiry_date')
            ->where('expiry_date', '<', now());
    }

    public function scopeByItemCode($query, $value)
    {
        return $query->where('item_code', $value);
    }
}
