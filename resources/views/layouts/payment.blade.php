<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khalti Payment Test</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://khalti.com/static/khalti-checkout.js"></script>
</head>

<body>
    <h1>Test Khalti Payment</h1>

    <button id="payBtn">Initiate Khalti Payment</button>

    {{-- <script>
        document.getElementById('payBtn').addEventListener('click', async () => {
            try {
                // 1️⃣ Initiate payment on your server
                const res = await fetch('/api/khalti/initiate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        amount: 1000,            // NPR amount
                        purchase_order_id: 'Order01',
                        purchase_order_name: 'Test Order',
                        name: 'Test User',
                        email: 'test@khalti.com',
                        phone: '9800000000'
                    })
                });

                const data = await res.json();
                console.log("Khalti Initiate Response:", data);

                if (!data.success || !data.data.payment_url) {
                    alert("Payment initiation failed. Check console.");
                    return;
                }

                // 2️⃣ Open Khalti Checkout modal
                const config = {
                    publicKey: "6347055bcd754893a053fdc636209663", // Your TEST public key
                    productIdentity: "Order01",
                    productName: "Test Order",
                    productUrl: window.location.href,
                    eventHandler: {
                        onSuccess: async function (payload) {
                            console.log("Payment completed:", payload);

                            // 3️⃣ Verify payment on your server
                            try {
                                const verifyRes = await fetch('/api/payment/verify', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify({
                                        token: payload.token,
                                        amount: 1000
                                    })
                                });

                                const verifyData = await verifyRes.json();
                                console.log("Payment verification:", verifyData);

                                if (verifyData.success) {
                                    alert("✅ Payment verified successfully!");
                                } else {
                                    alert("❌ Payment verification failed: " + (verifyData.message || 'Unknown error'));
                                }
                            } catch (err) {
                                console.error(err);
                                alert("Payment verification error");
                            }
                        },
                        onError: function (error) {
                            console.error("Payment failed:", error);
                            alert("Payment failed!");
                        },
                        onClose: function () {
                            console.log("Checkout closed");
                        }
                    },
                    paymentPreference: ["KHALTI", "EBANKING", "MOBILE_BANKING", "CONNECT_IPS", "SCT"]
                };

                const checkout = new KhaltiCheckout(config);
                checkout.show({ paymentUrl: data.data.payment_url, amount: 1000 * 100, productIdentity: "Order01", productName: "Test Order" });

            } catch (err) {
                console.error(err);
                alert("Payment initiation failed");
            }
        });
    </script> --}}

     <h1>eSewa Payment Test</h1>

    <p><strong>Amount:</strong> Rs. {{ $amount }}</p>
    <p><strong>Tax:</strong> Rs. {{ $tax_amount }}</p>
    <p><strong>Total:</strong> Rs. {{ $total_amount }}</p>
    <p><strong>Transaction ID:</strong> {{ $transaction_uuid }}</p>

    {{-- eSewa Payment Form --}}
    <form action="https://rc-epay.esewa.com.np/api/epay/main/v2/form" method="POST">
        <input type="hidden" name="amount" value="{{ $amount }}">
        <input type="hidden" name="tax_amount" value="{{ $tax_amount }}">
        <input type="hidden" name="total_amount" value="{{ $total_amount }}">
        <input type="hidden" name="transaction_uuid" value="{{ $transaction_uuid }}">
        <input type="hidden" name="product_code" value="{{ $product_code }}">
        <input type="hidden" name="product_service_charge" value="0">
        <input type="hidden" name="product_delivery_charge" value="0">
        <input type="hidden" name="success_url" value="{{ $success_url }}">
        <input type="hidden" name="failure_url" value="{{ $failure_url }}">
        <input type="hidden" name="signed_field_names" value="total_amount,transaction_uuid,product_code">
        <input type="hidden" name="signature" value="{{ $signature }}">
        
        <button type="submit" style="
            background-color: #1ba548;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;">
            Pay with eSewa
        </button>
    </form>


</body>

</html>