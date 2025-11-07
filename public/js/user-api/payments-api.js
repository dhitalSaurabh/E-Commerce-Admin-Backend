async function postPayment(amount, orderId, transactionId) {
    const authToken = localStorage.getItem('token');
    const body = {
        order_id: orderId,
        amount: amount,
        method: 'cash_on_delivery',
        status: 'pending', // or set to 'completed' if confirmed already
        transaction_id: transactionId, // null for COD
    };

    try {
        const response = await fetch('http://127.0.0.1:8000/api/customer/payments', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`,
            },
            body: JSON.stringify(body),
        });

        const result = await response.json();

        if (response.status == 200 || response.status == 201) {
            console.log("Payment Successful:", result.data);
            window.location.href("/");
        } else {
            console.error("Payment Failed:", result);
            alert('Payment failed: ' + result.message);
        }
    } catch (err) {
        console.error("Error:", err);
        alert('Error processing payment');
    }
}
