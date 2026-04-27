<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $inventory_item_id
 * @property int $user_id
 * @property string $movement_type
 * @property int $quantity
 * @property int $previous_quantity
 * @property int $new_quantity
 * @property string|null $reference_number
 * @property string|null $remarks
 * @property \Illuminate\Support\Carbon $movement_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $formatted_type
 * @property-read mixed $type_badge
 * @property-read \App\Models\InventoryItem $inventoryItem
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement adjustment()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement dateRange($startDate, $endDate)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement stockIn()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement stockOut()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereInventoryItemId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereMovementDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereMovementType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereNewQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement wherePreviousQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereReferenceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereRemarks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|StockMovement whereUserId($value)
 * @mixin \Eloquent
 */
class StockMovement extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'stock_movements';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'inventory_item_id',
        'movement_type',
        'quantity',
        'previous_quantity',
        'new_quantity',
        'reference_number',
        'remarks',
        'user_id',
        'movement_date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'previous_quantity' => 'integer',
            'new_quantity' => 'integer',
            'movement_date' => 'date',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * Get the inventory item.
     */
    public function inventoryItem()
    {
        return $this->belongsTo(InventoryItem::class);
    }

    /**
     * Get the user who made this movement.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for stock-in movements.
     */
    public function scopeStockIn($query)
    {
        return $query->where('movement_type', 'stock_in');
    }

    /**
     * Scope for stock-out movements.
     */
    public function scopeStockOut($query)
    {
        return $query->where('movement_type', 'stock_out');
    }

    /**
     * Scope for adjustment movements.
     */
    public function scopeAdjustment($query)
    {
        return $query->where('movement_type', 'adjustment');
    }

    /**
     * Scope for date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('movement_date', [$startDate, $endDate]);
    }

    /**
     * Get movement type badge color.
     */
    public function getTypeBadgeAttribute()
    {
        $colors = [
            'stock_in' => 'success',
            'stock_out' => 'danger',
            'adjustment' => 'warning',
            'return' => 'info',
        ];

        return $colors[$this->movement_type] ?? 'secondary';
    }

    /**
     * Get formatted movement type.
     */
    public function getFormattedTypeAttribute()
    {
        $types = [
            'stock_in' => 'Stock In',
            'stock_out' => 'Stock Out',
            'adjustment' => 'Adjustment',
            'return' => 'Return',
        ];

        return $types[$this->movement_type] ?? ucfirst($this->movement_type);
    }
}
