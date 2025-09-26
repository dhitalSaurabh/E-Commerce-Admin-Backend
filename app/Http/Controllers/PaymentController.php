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
    // initiate payment
public function initiatePayment(Request $request)
{
    $payload = [
        'return_url' => url('/api/verify-payment'),
        'website_url' => config('payment.khalti.website_url'),
        'amount' => 4000 * 100, // amount in paisa
        'purchase_order_id' => 1,
        'purchase_order_name' => 'Test Order',
        'customer_info' => [
            'name' => 'Test Customer',
            'email' => 'test@gmail.com',
            'phone' => 9800000001
        ]
    ];
 
    $response = Http::withHeaders([
        'Authorization' => 'key ' . config('payment.khalti.secret_key'),
        'Accept' => 'application/json',
    ])->post(config('payment.khalti.base_url') . '/api/v2/epayment/initiate/', $payload)->throw();
 
    return $response->json();
}

// Payment verification 

public function verifyPayment(Request $request)
{
    $response = Http::withHeaders([
        'Authorization' => 'key ' . config('payment.khalti.secret_key'),
        'Accept' => 'application/json',
    ])->post(config('payment.khalti.base_url') . '/api/v2/epayment/lookup/', [
        'pidx' => $request->pidx
    ])->throw();
 
    if ($response->successful()) {
        return redirect(config('payment.khalti.redirect') . '/payment/success');
    }
 
    return redirect(config('payment.khalti.redirect') . '/payment/failed');
}

}
