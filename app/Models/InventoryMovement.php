<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $inventory_control_id
 * @property string $movement_type
 * @property string|null $movement_reason
 * @property int $quantity
 * @property string|null $reason
 * @property string|null $reference_number
 * @property int|null $performed_by
 * @property int|null $target_barangay_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\InventoryControl $inventoryControl
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\Barangay|null $targetBarangay
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement adjustment()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement stockIn()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement stockOut()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement transfers()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement whereInventoryControlId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement whereMovementReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement whereMovementType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement wherePerformedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement whereReason($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement whereReferenceNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|InventoryMovement whereTargetBarangayId($value)
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
        'movement_reason',
        'quantity',
        'reason',
        'reference_number',
        'performed_by',
        'target_barangay_id',
    ];

    protected $casts = [
        'quantity' => 'integer',
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

    public function targetBarangay()
    {
        return $this->belongsTo(Barangay::class, 'target_barangay_id', 'barangay_id');
    }

    public function vaccinationReport()
    {
        return $this->belongsTo(VaccinationReport::class, 'vaccination_report_id');
    }

    public function scopeStockIn($query)
    {
        return $query->where('movement_type', 'in');
    }

    public function scopeStockOut($query)
    {
        return $query->where('movement_type', 'out');
    }

    public function scopeAdjustment($query)
    {
        return $query->where('movement_type', 'adjustment');
    }

    public function scopeTransfers($query)
    {
        return $query->where('movement_type', 'transfer');
    }
}
