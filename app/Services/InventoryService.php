<?php

namespace App\Services;

use App\Models\InventoryControl;
use App\Models\InventoryMovement;
use App\Models\VaccinationReport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InventoryService
{
    /**
     * Deduct inventory when a vaccination report is completed.
     *
     * Guards against double-deduction by checking for an existing
     * InventoryMovement linked to the vaccination report.
     *
     * @throws ValidationException if stock is insufficient
     */
    public function deductForVaccination(VaccinationReport $report): void
    {
        // Skip if no inventory item linked
        if (!$report->inventory_control_id) {
            return;
        }

        // Guard against double-deduction
        if (InventoryMovement::where('vaccination_report_id', $report->id)->exists()) {
            return;
        }

        $inventory = InventoryControl::find($report->inventory_control_id);
        if (!$inventory) {
            return;
        }

        $quantityDeducted = (int) ($report->quantity_deducted ?? 1);

        // Check sufficient stock
        if ($inventory->quantity < $quantityDeducted) {
            throw ValidationException::withMessages([
                'inventory_control_id' => "Insufficient stock for {$inventory->item_name}. Current quantity: {$inventory->quantity}.",
            ]);
        }

        DB::transaction(function () use ($inventory, $report, $quantityDeducted) {
            // Decrement quantity
            $inventory->decrement('quantity', $quantityDeducted);

            // Recalc status
            $newStatus = $inventory->quantity == 0 ? 'out_of_stock' : 'active';
            $inventory->update(['status' => $newStatus]);

            // Create movement record
            InventoryMovement::create([
                'inventory_control_id' => $inventory->id,
                'movement_type' => 'out',
                'movement_reason' => 'vaccination',
                'quantity' => $quantityDeducted,
                'reason' => "Vaccine administered for vaccination report #{$report->id}",
                'performed_by' => Auth::id(),
                'vaccination_report_id' => $report->id,
            ]);

            // Low-stock alert
            if ($inventory->isLowStock()) {
                \App\Services\NotificationService::inventoryLow($inventory->item_name, (int) $inventory->quantity);
            }
        });
    }
}
