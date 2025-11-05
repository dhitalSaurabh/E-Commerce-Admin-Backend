<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Log;

class EsewaController extends Controller
{
    // Step 1: Show payment form
    public function initiate(Request $request)
    {
        $fields = $request->validate([
            'order_id' => 'required|string',
            'cart_id' => 'required|string',
            'quantity' => 'required|integer',
            'total_amount' => 'required|numeric',
            'customer_name' => 'required|string',
            'customer_email' => 'required|email',
            'customer_phone' => 'required|string',
            // 'transaction_uuid' => 'nullable|string',
        ]);
        $amount = $request->total_amount;
        $tax_amount = 10;
        $total_amount = $amount + $tax_amount;
        $transaction_code = $request->transaction_code;
        $order_id = $request->order_id;
        $transaction_uuid = $request->transaction_uuid;
        $product_code = 'EPAYTEST';
        $success_url = route('esewa.verify');
        // $payload = json_decode(base64_decode($request->payload), true);

        $failure_url = route('esewa.failure');

        $data = "total_amount={$total_amount},transaction_uuid={$transaction_uuid},product_code={$product_code}";
        $signature = base64_encode(hash_hmac('sha256', $data, '8gBm/:&EnhH.1/q', true));

        return view('layouts.payment', compact(
            'order_id',
            'amount',
            'tax_amount',
            'total_amount',
            'transaction_uuid',
            'product_code',
            'success_url',
            'failure_url',
            'signature'
        ));
    }

    // Step 2: Verify payment
    public function verify(Request $request)
    {
        Log::info('Verify method called.', ['request' => $request->all()]);
        // $order_id = $request->order_id; // ✅ Get order ID from query param
        $decoded = json_decode(base64_decode($request->data), true);
        if (!$decoded) {
            Log::error('Invalid eSewa response: unable to decode base64 data');
            return response()->json(['success' => false, 'message' => 'Invalid response from eSewa']);
        }
        // dump($decoded);
        Log::info('Decoded eSewa data:', $decoded);
        $response = Http::asForm()->get('https://rc.esewa.com.np/api/epay/transaction/status/', [
            'product_code' => $decoded['product_code'],
            'total_amount' => $decoded['total_amount'],
            'transaction_uuid' => $decoded['transaction_uuid'],
        ]);
        $transaction_code = $decoded['transaction_uuid'];
        $responseData = json_decode($response->body(), true);
        Log::info('eSewa verification response:', ['body' => $responseData]);

        if (isset($responseData['status']) && $responseData['status'] === 'COMPLETE') {
            Log::info('Payment status is COMPLETE.');
            $order = Order::where('transaction_code', $transaction_code)->first();
            // dump($order);
            if ($order) {
                Log::info('Order found. Updating status.');
                $order->status = 'paid';
                $order->save();
                try {
                    $paymet = Payment::create([
                        'customer_id' => $order->customer_id,
                        'order_id' => $order->id,
                        'amount' => $responseData['total_amount'],
                        'method' => 'esewa',
                        'status' => 'completed',
                        'transaction_id' => $transaction_code,
                    ]);
                    $paymet->save();
                } catch (\Exception $e) {
                    Log::error('Error creating payment record: ' . $e->getMessage());
                }
                Log::info('Order status updated successfully.');
                return "Payment successful.";

            } else {
                Log::warning('Order not found.', ['order_id' => $transaction_code]);
                return response()->json(['success' => true, 'message' => 'order not found.']);
            }

        }
        // If payment is not successful, log the error
        Log::warning('Payment failed or incomplete.', ['response' => $response->body()]);
        return response()->json(['success' => false, 'message' => 'Payment failed']);
    }

    public function success(Request $request)
    {
        // $order = Order::find($request->order_id);
        // dump($request->order_id);
        // if ($order) {
        //     Log::info('Order found. Updating status.');
        //     $order->status = 'paid';
        //     $order->save();
        //     Log::info('Order status updated successfully.');
        //     return response()->json(['success' => true, 'message' => '✅ Payment successful.']);
        // }
        // Log::warning('Order not found.', ['order_id' => $request->order_id]);
        // return response()->json(['success' => true, 'message' => 'order not found.']);
        return '✅ eSewa Payment Success!';
    }

    public function failure()
    {
        return '❌ eSewa Payment Failed!';
    }
}
