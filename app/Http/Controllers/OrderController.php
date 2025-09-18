<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Http\Requests\StoreorderRequest;
use App\Http\Requests\UpdateorderRequest;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'message' => 'Orders retrieved successfully',
            'data' => Order::with(['customer', 'address'])->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'user_address_id' => 'required|exists:user_addresses,id',
            'status' => 'pending',
            'total_amount' => 'nullable',
        ]);

        $order = $request->user()->orders()->create($fields);

        return response()->json([
            'message' => 'Order created successfully. Add items separately.',
            'data' => $order,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(order $order)
    {
        return response()->json([
            'message' => 'Orders retrieved successfully',
            'data' => $order->load(['customer', 'address']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, order $order)
    {
        $fields = $request->validate([
            // 'user_address_id' => 'nullable|exists:user_addresses,id',
            'status' => 'pending',
            'total_amount' => 'nullable',
        ]);

        $order->update($fields);

        return response()->json([
            'message' => 'Order created successfully. Add items separately.',
            'data' => $order,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(order $order)
    {
        $order->delete();
        return response()->json([
            'message' => 'Order deleted successfully',
        ]);
    }
}
