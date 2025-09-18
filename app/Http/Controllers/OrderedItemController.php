<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderedItem;
use App\Models\ProductVarient;
use Illuminate\Http\Request;

class OrderedItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'message' => 'Ordered items retrieved successfully',
            'data' => OrderedItem::with(['order', 'variant'])->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'variant_id' => 'required',
            'quantity' => 'required|integer|min:1',
            'price' => 'required',
        ]);
        $variant = ProductVarient::findOrFail($fields['variant_id']);
        $total = $fields['price'];
        $orderedItem = $request->user()->ordereditems()->create($fields);
        $order = Order::findOrFail($fields['order_id']);
        $order->total_amount = $total;
        $order->save();
        return response()->json([
            'message' => 'Ordered item created successfully',
            'data' => $orderedItem,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(OrderedItem $orderedItem)
    {
        // $item = OrderedItem::with(['order', 'variant'])->findOrFail($id);

        return response()->json([
            'message' => 'Ordered item retrieved successfully',
            'data' => $orderedItem->load(['order', 'variant']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OrderedItem $orderedItem)
    {
        $fields = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'variant_id' => 'required|exists:product_varients,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required',
        ]);
        $variant = ProductVariant::findOrFail($fields['variant_id']);
        $total = $fields['price'];
        $orderedItem->update($fields);
        $order = Order::findOrFail($fields['ordered_id']);
        $order->total_amount = $total;
        $order->save();
        return response()->json([
            'message' => 'Ordered item created successfully',
            'data' => $orderedItem,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OrderedItem $orderedItem)
    {
        $orderedItem->delete();
        return response()->json([
            'message' => 'Ordered item deleted successfully',
        ]);
    }
}
