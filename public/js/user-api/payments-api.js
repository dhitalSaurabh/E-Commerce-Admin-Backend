async function postPayment(orderId, amount, method, transactionId = null) {
    const authToken = localStorage.getItem('token');

    const body = {
        order_id: orderId,
        amount: amount,
        method: method,
        status: 'pending', // or set to 'completed' if confirmed already
        transaction_id: transactionId, // null for COD
    };

    try {
        const response = await fetch('http://127.0.0.1:8000/api/payments', {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${authToken}`,
            },
            body: JSON.stringify(body),
        });

        const result = await response.json();

        if (response.ok) {
            console.log("Payment Successful:", result.data);
            alert('Payment created successfully!');
        } else {
            console.error("Payment Failed:", result);
            alert('Payment failed: ' + result.message);
        }
    } catch (err) {
        console.error("Error:", err);
        alert('Error processing payment');
    }
}
