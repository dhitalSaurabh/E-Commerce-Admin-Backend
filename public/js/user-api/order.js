// Post Products 
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('orderForm');
    const errorMessage = document.getElementById('errorMessage');

    if (!form) return;

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        // console.log(formData);
        try {
            const auth_token = localStorage.getItem('token');
            // const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch("http://127.0.0.1:8000/api/customer/orders", {
                method: 'POST',
                headers: {
                    'Accept': 'application/json',
                    // "X-CSRF-TOKEN": token,
                    "Authorization": `Bearer ${auth_token}`,
                },
                credentials: 'include',
                // body: JSON.stringify({ name, slug, description, price, image })
                body: formData,
            });
            console.log("Response received");
            const responseData = await response.json();

            if (!response.ok) {
                errorMessage.textContent = responseData.message || 'Error submitting form.';
                console.error('Validation Errors:', responseData.errors);
            } else {
                alert('Product ordered Successfully');
                form.reset();

                errorMessage.textContent = '';
                // window.location.reload()
                ;
            }

        } catch (err) {
            console.error(err);
            errorMessage.textContent = 'An unexpected error occurred.';
        }
    });
});


// Load Carts
async function loadOrders() {
    const container = document.getElementById('loadOrdersView');
    if (!container) return;

    try {
        const auth_token = localStorage.getItem('token');
        const response = await fetch('http://127.0.0.1:8000/api/customer/user/orderedItems', {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${auth_token}`,
            }
        });

        const result = await response.json();
        const carts = result.data;
        container.innerHTML = '';

        if (!Array.isArray(carts) || carts.length === 0) {
            container.innerHTML = '<p class="text-gray-500">Your cart is empty.</p>';
            return;
        }

        carts.forEach(cart => {
            const {
                id: cartId,
                quantity,
                created_at,
                variant,
                order,
                customer
            } = cart;

            const {
                size,
                color,
                material,
                sku,
                image,
                price
            } = variant;



            const formattedOrderDate = new Date(order.created_at).toLocaleString();
            const totalAmount = order.total_amount;
            const orderStatus = order.status;

            // Extract customer info safely
            const customerName = customer?.name || "Unknown";
            const customerEmail = customer?.email || "unknown@example.com";
            const customerPhone = customer?.mobile_number || "9800000000";
            const transaction_code = order?.transaction_code || "";

            const card = document.createElement('div');
            card.className = `
                variant-card opacity-0 transform translate-y-5
                transition-all duration-500 ease-out
                border rounded-lg shadow-lg p-0 bg-white w-full sm:max-w-sm overflow-hidden
                hover:shadow-2xl hover:scale-[1.02]
            `.trim();

            card.innerHTML = `
                <div class="relative">
                    <img src="${image}" alt="Product Image"
                        class="w-full h-52 object-cover transition-transform duration-300 ease-in-out hover:scale-105">
                    
                    <!-- Overlay badge -->
                    <div class="absolute top-0 left-0 right-0 flex flex-wrap justify-between p-2 text-xs font-semibold bg-black bg-opacity-50 text-white">
                        <span>Qty: ${quantity}</span>
                        <span>Status: ${escapeHtml(orderStatus)}</span>
                        <span>Ordered: ${formattedOrderDate}</span>
                    </div>
                </div>

                <div class="p-4">
                    <h2 class="text-lg font-bold text-gray-800 mb-2">Variant Info</h2>
                    <ul class="text-sm text-gray-700 space-y-1 mb-4">
                        <li><strong>SKU:</strong> ${escapeHtml(sku)}</li>
                        <li><strong>Size(s):</strong> ${escapeHtml(size)}</li>
                        <li><strong>Color(s):</strong> ${escapeHtml(color)}</li>
                        <li><strong>Material:</strong> ${escapeHtml(material)}</li>
                    </ul>

                    <h2 class="text-lg font-bold text-gray-800 mb-2">Order Info</h2>
                    <ul class="text-sm text-gray-700 space-y-1 mb-4">
                        <li><strong>Price per Item:</strong> ₹${price}</li>
                        <li><strong>Quantity:</strong> ${quantity}</li>
                        <li><strong>Total Order Amount:</strong> ₹${totalAmount}</li>
                    </ul>

                    <div class="flex gap-2">
                    ${orderStatus === 'paid'
                    ? `<button disabled class="flex-1 px-4 py-2 bg-green-400 text-white font-semibold rounded-lg">Paid</button>`
                    : `<button 
                            onclick='openPayment(
                     ${cart.id},
                     ${order.id},
                     ${quantity},
                     ${totalAmount},
                    ${JSON.stringify(customerName)},
                    ${JSON.stringify(customerEmail)},
                    ${JSON.stringify(customerPhone)},
                    ${JSON.stringify(transaction_code)}
                        )'
                    class="flex-1 px-4 py-2 bg-green-500 text-white font-semibold rounded-lg">
                    Pay Now
                </button>`
                }
                        ${orderStatus === 'paid' ?
                    `<button disabled
                            class="flex-1 px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg
                                   hover:bg-blue-600 transition-all duration-300 shadow hover:shadow-md">
                            Already Paid 
                        </button>`
                    : `
                         <button
                            onclick="deleteorderedItem(${cart.id})"
                            class="flex-1 px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg
                                   hover:bg-blue-600 transition-all duration-300 shadow hover:shadow-md">
                            Cancel Order
                        </button>
                         `
                }
                    </div>
                </div>
            `;

            container.appendChild(card);

            setTimeout(() => {
                card.classList.remove('opacity-0', 'translate-y-5');
                card.classList.add('opacity-100', 'translate-y-0');
            }, 50);
        });

    } catch (error) {
        console.error("Failed to fetch orders:", error);
        container.innerHTML = "<p class='text-red-500'>Failed to load orders.</p>";
    }
}

document.addEventListener('DOMContentLoaded', loadOrders);
async function openPayment(cartId, orderId, quantity, totalAmount, name, email, phone, transaction_uuid) {
    // const query = new URLSearchParams({
    //     orderId: orderId,
    //     cart_id: cartId,
    //     quantity,
    //     total_amount: totalAmount,
    //     customer_name: name,
    //     customer_email: email,
    //     customer_phone: phone,
    //     transaction_uuid: transaction_code,
    // });
    // window.open(`/proceed-to-payment?${query.toString()}`);
    try {
        const response = await fetch('/api/esewa/initiate', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
            },
            body: JSON.stringify({
                order_id: orderId,
                cart_id: cartId,
                quantity: quantity,
                total_amount: totalAmount,
                customer_name: name,
                customer_email: email,
                customer_phone: phone,
                transaction_code: transaction_uuid,
            })
        });
        // const text = await response.text();
        // console.log("🔍 Raw response:", text);
        const data = await response.json();
        if (!response.ok) {
            // const errorData = await response.text();
            console.error("❌ Failed to initiate payment:", errorData);
            alert("Failed to start payment. Please try again.");
            return;
        }

        console.log("✅ eSewa initiation response:", data);
        if (data && data.payment_url) {
            window.location.href = data.payment_url;
        } else {
            console.error("❌ Invalid payment initiation response:", data);
            alert("Failed to start payment. Please try again.");
        }
    } catch (error) {
        console.error("💥 Error initiating eSewa payment:", error);
        alert("Something went wrong while connecting to eSewa.");
    }
}

async function deleteorderedItem(id) {

    try {
        const oid = id;
        const auth_token = localStorage.getItem('token');
        // const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const response = await fetch(`http://127.0.0.1:8000/api/customer/orderedItems/${oid}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                // "X-CSRF-TOKEN": token,
                "Authorization": `Bearer ${auth_token}`,
            },
            credentials: 'include',
            // body: JSON.stringify({ name, slug, description, price, image })
            // body: formData,
        });
        console.log("Response received");
        // const responseData = await response.json();

        if (!response.ok) {
            errorMessage.textContent = responseData.message || 'Error submitting form.';
            console.error('Validation Errors:', responseData.errors);
        } else {
            alert('Product deleted Successfully');
            // form.reset();
            window.location.reload();

            errorMessage.textContent = '';
            // window.location.reload()
            ;
        }

    } catch (err) {
        console.error(err);
        errorMessage.textContent = 'An unexpected error occurred.';
    }

}