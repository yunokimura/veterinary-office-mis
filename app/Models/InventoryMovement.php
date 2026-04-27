<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $inventory_control_id
 * @property string $movement_type
 * @property int $quantity
 * @property string|null $reason
 * @property int|null $performed_by
 * @property int|null $barangay_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\InventoryControl $inventoryControl
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement whereBarangayId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement whereInventoryControlId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement whereMovementType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement wherePerformedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InventoryMovement extends Model
{
    use HasFactory;

    protected $table = 'inventory_movements';

    protected $fillable = [
        'inventory_control_id',
        'movement_type',
        'quantity',
        'reason',
        'performed_by',
        'barangay_id',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'movement_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function inventoryControl()
    {
        return $this->belongsTo(InventoryControl::class, 'inventory_control_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'performed_by');
    }
}
