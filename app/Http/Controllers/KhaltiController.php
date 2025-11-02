<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class KhaltiController extends Controller
{
    // 1️⃣ Initiate payment
    public function initiatePayment(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric',
            'purchase_order_id' => 'required|string',
            'purchase_order_name' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);

        $payload = [
            "return_url" => url('/'), // where Khalti redirects after payment
            "website_url" => url('/'),
            "amount" => $validated['amount'] * 100, // convert to paisa
            "purchase_order_id" => $validated['purchase_order_id'],
            "purchase_order_name" => $validated['purchase_order_name'],
            "customer_info" => [
                "name" => $validated['name'],
                "email" => $validated['email'],
                "phone" => $validated['phone'],
            ],
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Key ' . env('KHALTI_SECRET_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://dev.khalti.com/api/v2/epayment/initiate/', $payload);

        $data = $response->json();

        return response()->json([
            'success' => $response->successful(),
            'data' => $data
        ], $response->status());
    }

    // 2️⃣ Verify payment
    public function verifyPayment(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $payload = [
            'token' => $request->token,
            'amount' => $request->amount * 100, // paisa
        ];

        $response = Http::withHeaders([
            'Authorization' => 'Key ' . env('KHALTI_SECRET_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://khalti.com/api/v2/payment/verify/', $payload);

        $data = $response->json();

        if ($response->successful() && isset($data['idx'])) {
            return response()->json([
                'success' => true,
                'message' => 'Payment verified successfully!',
                'data' => $data,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => $data['detail'] ?? 'Payment verification failed',
            'data' => $data,
        ], 400);
    }
}
