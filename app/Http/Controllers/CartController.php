<?php

namespace App\Http\Controllers;

use App\Models\cart;
use Illuminate\Http\Request;
use function PHPUnit\Framework\returnArgument;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $customerId = $request->user()->customer->cart;
        return response()->json([
            'message' => 'Carts retrived successfully',
            // 'data' => Cart::with('variant')->where('customer_id', $customerId)->get(),
            'data' => Cart::with('variant')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'variant_id' => 'required|exists:product_varients,id',
            'quantity' => 'required|integer|min:1',
        ]);
        $cart = $request->user()->carts()->create($fields);
        return response()->json([
            'message' => 'Item added to cart successfully',
            'data' => $cart,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    // public function show(cart $cart)
    // {
    //     return response()->json([
    //         'message' => 'Cart item retrieved successfully',
    //         'data' => $cart->load('variant'),
    //     ]);
    // }

    public function show()
    {
        $user = auth()->user();

        // Get the customer related to the authenticated user
        // $customer = $user->customer;

        // Get carts for that customer with related variant
        $carts = $user->carts()->with('variant')->get();

        if ($carts->isEmpty()) {
            return response()->json([
                'message' => 'No carts found for this customer.'
            ], 404);
        }

        return response()->json([
            'message' => 'Carts retrieved successfully.',
            'data' => $carts
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, cart $cart)
    {
        $fields = $request->validate([
            'variant_id' => 'nullable|exists:product_varients,id',
            'quantity' => 'nullable|integer|min:1',
        ]);
        $cart->update($fields);
        return response()->json([
            'message' => 'Item updated to cart successfully',
            'data' => $cart,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(cart $cart)
    {
        $cart->delete();
        return response()->json([
            'message' => 'Cart deleted successfully',
        ]);
    }
}
