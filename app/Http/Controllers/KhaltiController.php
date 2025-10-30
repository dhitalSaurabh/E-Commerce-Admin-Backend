<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KhaltiController extends Controller
{
    public function initiate(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'order_id' => 'required|string',
            'product_name' => 'required|string'
        ]);

        $payload = [
            "return_url" => config('khalti.base_url') . "/payment/success",
            "website_url" => config('khalti.base_url'),
            "amount" => $request->amount * 100, // in paisa if required by Khalti
            "purchase_order_id" => $request->order_id,
            "purchase_order_name" => $request->product_name,
            "customer_info" => [
                "name" => $request->customer_name ?? "Test Customer",
                "email" => $request->customer_email ?? "test@khalti.com",
                "phone" => $request->customer_phone ?? "9800000001"
            ]
        ];

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Key ' . config('khalti.secret_key'),
                'Content-Type' => 'application/json'
            ])->post('https://dev.khalti.com/api/v2/epayment/initiate/', $payload);

            if ($response->successful()) {
                return response()->json([
                    'success' => true,
                    'data' => $response->json()
                ]);
            } else {
                Log::error('Khalti API Error: ' . $response->body());
                return response()->json([
                    'success' => false,
                    'message' => 'Payment initiation failed',
                    'details' => $response->body()
                ], 400);
            }
        } catch (\Exception $e) {
            Log::error('Khalti Exception: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Payment initiation exception',
                'details' => $e->getMessage()
            ], 500);
        }
    }
}
