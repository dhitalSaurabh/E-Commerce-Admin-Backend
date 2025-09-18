<?php

namespace App\Http\Controllers;

use App\Models\payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'message' => 'Payments retrieved successfully',
            'data' => Payment::with(['order', 'customer'])->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            // 'customer_id' => 'nullable|exists:customers,id',
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric|min:0',
            'method' => 'required|in:esewa,khalti,cash_on_delivery,bank_transfer',
            'status' => 'in:pending,completed,failed',
            'transaction_id' => 'nullable|string|max:255',
        ]);

        $payment = $request->user()->payments()->create($fields);
        return response()->json([
            'message' => 'Payment created successfully',
            'data' => $payment,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(payment $payment)
    {
        return response()->json([
            'message' => 'Payment retrieved successfully',
            'data' => $payment->load(['order', 'customer']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, payment $payment)
    {
        $fields = $request->validate([
            // 'customer_id' => 'required|exists:customers,id',
            'order_id' => 'nullable|exists:orders,id',
            'amount' => 'nullable|numeric|min:0',
            'method' => 'nullable|in:esewa,khalti,cash_on_delivery,bank_transfer',
            'status' => 'in:pending,completed,failed',
            'transaction_id' => 'nullable|string|max:255',
        ]);

        $payment->update($fields);
        return response()->json([
            'message' => 'Payment updated successfully',
            'data' => $payment,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(payment $payment)
    {
        $payment->delete();
        return response()->json([
            'message' => 'Payment deleted successfully',
        ]);
    }
}
