<?php

namespace App\Http\Controllers\AdminAsst;

use App\Http\Controllers\Controller;
use App\Models\InventoryControl;
use App\Models\InventoryMovement;
use App\Models\Barangay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = InventoryControl::query();

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('item_name', 'like', '%' . $request->search . '%')
                    ->orWhere('item_code', 'like', '%' . $request->search . '%');
            });
        }

        $items = $query->orderBy('item_name')->paginate(15);

        $lowStockCount = InventoryControl::lowStock()->count();

        $totalItems = InventoryControl::count();
        $categoryCount = InventoryControl::distinct('category')->count('category');
        $outOfStockCount = InventoryControl::where('status', 'out_of_stock')->count();
        $totalValue = (float) InventoryControl::sum(DB::raw('COALESCE(quantity, 0) * COALESCE(unit_cost, 0)'));
        $avgCost = (float) InventoryControl::avg('unit_cost');

        $barangays = Barangay::orderBy('barangay_name')->get();

        if ($request->ajax() || $request->wantsJson()) {
            $html = view('admin-asst.inventory._table', compact('items'))->render();
            $links = $items->withQueryString()->links();
            $pagination = $links instanceof \Illuminate\Contracts\Support\Htmlable
                ? $links->toHtml()
                : (string) $links;

            return response()->json([
                'success' => true,
                'html' => $html,
                'pagination' => $pagination,
                'has_results' => $items->count() > 0,
            ]);
        }

        return view('admin-asst.inventory.index', compact('items', 'lowStockCount', 'totalItems', 'categoryCount', 'outOfStockCount', 'totalValue', 'avgCost', 'barangays'));
    }

    public function create()
    {
        return view('admin-asst.inventory.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'item_code' => 'nullable|string|max:100|unique:inventory_controls,item_code',
            'category' => 'required|string|max:100',
            'unit' => 'nullable|string|max:50',
            'quantity' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'unit_cost' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'expiry_date' => 'nullable|date',
            'batch_number' => 'nullable|string|max:100',
            'supplier' => 'nullable|string|max:255',
            'storage_location' => 'nullable|string|max:255',
        ]);

        $validated['created_by'] = Auth::id();
        $validated['status'] = $validated['quantity'] == 0 ? 'out_of_stock' : 'active';

        InventoryControl::create($validated);

        return redirect()->route('admin-asst.inventory.index')
            ->with('success', 'Inventory item created successfully.');
    }

    public function show(InventoryControl $inventory)
    {
        $movements = $inventory->movements()
            ->with('user', 'targetBarangay')
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('admin-asst.inventory.show', compact('inventory', 'movements'));
    }

    public function edit(InventoryControl $inventory)
    {
        return view('admin-asst.inventory.edit', compact('inventory'));
    }

    public function update(Request $request, InventoryControl $inventory)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'item_code' => 'nullable|string|max:100|unique:inventory_controls,item_code,' . $inventory->id,
            'category' => 'required|string|max:100',
            'unit' => 'nullable|string|max:50',
            'quantity' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'unit_cost' => 'nullable|numeric|min:0',
            'description' => 'nullable|string',
            'expiry_date' => 'nullable|date',
            'batch_number' => 'nullable|string|max:100',
            'supplier' => 'nullable|string|max:255',
            'storage_location' => 'nullable|string|max:255',
        ]);

        $validated['status'] = $validated['quantity'] == 0 ? 'out_of_stock' : 'active';

        $inventory->update($validated);

        return redirect()->route('admin-asst.inventory.show', $inventory)
            ->with('success', 'Inventory item updated successfully.');
    }

    public function destroy(InventoryControl $inventory)
    {
        $inventory->delete();

        return redirect()->route('admin-asst.inventory.index')
            ->with('success', 'Inventory item deleted successfully.');
    }

    public function lowStock()
    {
        $items = InventoryControl::lowStock()
            ->orderBy('quantity')
            ->paginate(15);

        return view('admin-asst.inventory.low-stock', compact('items'));
    }

    public function expiring()
    {
        $items = InventoryControl::expiringSoon()
            ->orderBy('expiry_date')
            ->paginate(15);

        return view('admin-asst.inventory.expiring', compact('items'));
    }

    public function movements(Request $request)
    {
        $query = InventoryMovement::query()
            ->with('inventoryControl', 'user', 'targetBarangay');

        if ($request->filled('movement_type')) {
            $query->where('movement_type', $request->movement_type);
        }

        if ($request->filled('inventory_control_id')) {
            $query->where('inventory_control_id', $request->inventory_control_id);
        }

        if ($request->filled('search')) {
            $query->whereHas('inventoryControl', function ($q) use ($request) {
                $q->where('item_name', 'like', '%' . $request->search . '%');
            });
        }

        $movements = $query->orderByDesc('created_at')->paginate(20);

        return view('admin-asst.inventory.movements', compact('movements'));
    }

    public function stockInForm(InventoryControl $inventory)
    {
        return view('admin-asst.inventory.stock-in', compact('inventory'));
    }

    public function stockIn(Request $request, InventoryControl $inventory)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:500',
            'reference_number' => 'nullable|string|max:100',
            'movement_reason' => 'nullable|string|max:100',
        ]);

        $previousQuantity = $inventory->quantity;
        $inventory->increment('quantity', $validated['quantity']);

        if ($inventory->status === 'out_of_stock' && $inventory->quantity > 0) {
            $inventory->update(['status' => 'active']);
        }

        InventoryMovement::create([
            'inventory_control_id' => $inventory->id,
            'movement_type' => 'in',
            'movement_reason' => $validated['movement_reason'],
            'quantity' => $validated['quantity'],
            'reason' => $validated['reason'],
            'reference_number' => $validated['reference_number'],
            'performed_by' => Auth::id(),
        ]);

        return redirect()->route('admin-asst.inventory.show', $inventory)
            ->with('success', 'Stock added successfully. Quantity updated from ' . $previousQuantity . ' to ' . $inventory->quantity . '.');
    }

    public function stockOutForm(InventoryControl $inventory)
    {
        return view('admin-asst.inventory.stock-out', compact('inventory'));
    }

    public function stockOut(Request $request, InventoryControl $inventory)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:500',
            'reference_number' => 'nullable|string|max:100',
            'movement_reason' => 'nullable|string|max:100',
        ]);

        if ($validated['quantity'] > $inventory->quantity) {
            return back()->withErrors(['quantity' => 'Insufficient stock. Current quantity: ' . $inventory->quantity]);
        }

        $previousQuantity = $inventory->quantity;
        $inventory->decrement('quantity', $validated['quantity']);

        if ($inventory->quantity == 0) {
            $inventory->update(['status' => 'out_of_stock']);
        }

        InventoryMovement::create([
            'inventory_control_id' => $inventory->id,
            'movement_type' => 'out',
            'movement_reason' => $validated['movement_reason'],
            'quantity' => $validated['quantity'],
            'reason' => $validated['reason'],
            'reference_number' => $validated['reference_number'],
            'performed_by' => Auth::id(),
        ]);

        return redirect()->route('admin-asst.inventory.show', $inventory)
            ->with('success', 'Stock removed successfully. Quantity updated from ' . $previousQuantity . ' to ' . $inventory->quantity . '.');
    }

    public function adjustmentForm(InventoryControl $inventory)
    {
        return view('admin-asst.inventory.adjustment', compact('inventory'));
    }

    public function adjustment(Request $request, InventoryControl $inventory)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer',
            'reason' => 'required|string|max:500',
            'reference_number' => 'nullable|string|max:100',
            'movement_reason' => 'nullable|string|max:100',
        ]);

        $newQuantity = $validated['quantity'];

        if ($newQuantity < 0) {
            return back()->withErrors(['quantity' => 'Quantity cannot be negative.']);
        }

        $previousQuantity = $inventory->quantity;
        $inventory->update(['quantity' => $newQuantity]);

        if ($newQuantity == 0) {
            $inventory->update(['status' => 'out_of_stock']);
        } else {
            $inventory->update(['status' => 'active']);
        }

        InventoryMovement::create([
            'inventory_control_id' => $inventory->id,
            'movement_type' => 'adjustment',
            'movement_reason' => $validated['movement_reason'],
            'quantity' => abs($newQuantity - $previousQuantity),
            'reason' => $validated['reason'],
            'reference_number' => $validated['reference_number'],
            'performed_by' => Auth::id(),
        ]);

        return redirect()->route('admin-asst.inventory.show', $inventory)
            ->with('success', 'Quantity adjusted from ' . $previousQuantity . ' to ' . $newQuantity . '.');
    }

    public function transferForm(InventoryControl $inventory)
    {
        $barangays = Barangay::orderBy('barangay_name')->get();
        return view('admin-asst.inventory.transfer', compact('inventory', 'barangays'));
    }

    public function transfer(Request $request, InventoryControl $inventory)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'target_barangay_id' => 'required|exists:barangays,barangay_id',
            'reason' => 'nullable|string|max:500',
            'reference_number' => 'nullable|string|max:100',
            'movement_reason' => 'nullable|string|max:100',
        ]);

        if ($validated['quantity'] > $inventory->quantity) {
            return back()->withErrors(['quantity' => 'Insufficient stock. Current quantity: ' . $inventory->quantity]);
        }

        $previousQuantity = $inventory->quantity;
        $inventory->decrement('quantity', $validated['quantity']);

        if ($inventory->quantity == 0) {
            $inventory->update(['status' => 'out_of_stock']);
        }

        InventoryMovement::create([
            'inventory_control_id' => $inventory->id,
            'movement_type' => 'transfer',
            'movement_reason' => $validated['movement_reason'],
            'quantity' => $validated['quantity'],
            'reason' => $validated['reason'],
            'reference_number' => $validated['reference_number'],
            'performed_by' => Auth::id(),
            'target_barangay_id' => $validated['target_barangay_id'],
        ]);

        return redirect()->route('admin-asst.inventory.show', $inventory)
            ->with('success', 'Stock transferred successfully. Quantity updated from ' . $previousQuantity . ' to ' . $inventory->quantity . '.');
    }
}
