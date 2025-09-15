<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $inventories = Inventory::with(['variant.product'])->get();
        return response()->json([
            'message' => 'Inventories Retrieved',
            'data' => $inventories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            // 'user_id' => 'required|exists:users,id',
            'variant_id' => 'required|exists:product_varients,id',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        // $inventory = Inventory::create($validated);
        $inventory = $request->user()->inventories()->create($validated);

        return response()->json([
            'message' => 'Inventory Created',
            'data' => $inventory
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Inventory $inventory)
    {
        // $inventory = Inventory::with(['variant.product'])->findOrFail($inventory);

        return response()->json([
            'message' => 'Inventory Retrieved',
            'data' => $inventory->load('variant.product'),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inventory $inventory)
    {
        // $inventory = Inventory::findOrFail($inventory);

        $validated = $request->validate([
            'stock_quantity' => 'sometimes|required|integer|min:0',
        ]);

        $inventory->update($validated);

        return response()->json([
            'message' => 'Inventory Updated',
            'data' => $inventory
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inventory $inventory)
    {
        // $inventory = Inventory::findOrFail($inventory);
        $inventory->delete();

        return response()->json([
            'message' => 'Inventory Deleted'
        ]);
    }
}
