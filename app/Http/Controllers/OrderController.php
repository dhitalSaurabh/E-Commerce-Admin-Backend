<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderedItem;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            // 'user_address_id' => 'required|exists:user_addresses,id',
            'status' => 'nullable|in:pending,paid,shipped,delivered,cancelled',
            'total_amount' => 'nullable|numeric',
            'variant_id' => 'required|exists:product_varients,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
        ]);

        // 🟨 Start transaction (missing in your code)
        DB::beginTransaction();
        $user = $request->user();

        // Attempt to get the address
        $address = $user->useraddress()->first();

        if (!$address) {
            return response()->json([
                'message' => 'No address found for this customer.',
            ], 422);
        }
        try {
            $user = Auth::guard('customer')->user();

            if (!$user) {
                throw new \Exception('Unauthorized - No customer is logged in.');
            }

            // ✅ Create order
            $order = $user->orders()->create([
                'user_address_id' => $address->id,
                'status' => $fields['status'] ?? 'pending',
                'total_amount' => $fields['total_amount'] ?? 0,
            ]);

            // ✅ Create ordered item
            $order->orderedItems()->create([
                'variant_id' => $fields['variant_id'],
                'quantity' => $fields['quantity'],
                'price' => $fields['price'],
                'customer_id' => $request->user()->id,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Order created successfully.',
                'data' => $order->load('orderedItems'),
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Failed to place order.',
                'error' => $e->getMessage(),
            ], 500);
        }
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
