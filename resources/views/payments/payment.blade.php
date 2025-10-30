@extends('./layouts.userdash')

@section('content')
    <script src="https://khalti.com/static/khalti-checkout.js"></script>
    <h1>Payment</h1>
    {{-- Your clothes table or grid --}}
    <button id="payBtn">Pay with Khalti</button>
    <script>
        const urlParams = new URLSearchParams(window.location.search);

        const cartId = urlParams.get('cart_id');
        const orderId = urlParams.get('order_id');
        const quantity = urlParams.get('quantity');
        const totalAmount = urlParams.get('totalAmount');
        const name = urlParams.get('name');
        const email = urlParams.get('email');
        const mobile = urlParams.get('mobile');

        console.log({
            cartId,
            orderId,
            quantity,
            totalAmount,
            name,
            email,
            mobile
        });
    </script>
    <script>
        document.getElementById('payBtn').addEventListener('click', function () {
            const config = {
                publicKey: "test_public_key_dc74b7e8dbb14d15b876d0a9d43d77b1", // replace
                productIdentity: orderId,
                productName: "Order #" + orderId,
                productUrl: window.location.href,
                eventHandler: {
                    onSuccess(payload) {
                        console.log("Payment success:", payload);

                        // Send verification to backend
                        fetch("http://127.0.0.1:8000/api/khalti/initiate", {
                            method: "POST",
                            headers: {
                                "Content-Type": "application/json",
                                "Authorization": "Bearer " + localStorage.getItem("token"),
                            },
                            body: JSON.stringify({
                                token: payload.token,
                                amount: totalAmount * 100, // paisa
                                order_id: orderId
                            })
                        })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    alert("Payment Verified!");
                                    window.location.href = "/orders"; // redirect back
                                } else {
                                    alert("Verification failed");
                                }
                            });
                    },
                    onError(error) {
                        console.error(error);
                        alert("Payment failed!");
                    },
                    onClose() {
                        console.log("Checkout closed");
                    }
                }
            };

            const checkout = new KhaltiCheckout(config);
            checkout.show({ amount: totalAmount * 100 });
        });
    </script>
@endsection