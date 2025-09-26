// Post Carts 
// document.addEventListener('DOMContentLoaded', () => {
async function PostCartsToServer(id) {
    const form = document.getElementById('AddCartForm');
    const errorMessage = document.getElementById('errorMessage');

    if (!form) return;

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        formData.append('variant_id', id);
        console.log(formData);
        // const name = document.getElementById('name').value;
        // const slug = document.getElementById('slug').value;
        // const description = document.getElementById('description').value;
        // const price = document.getElementById('price').value;
        // const image = document.getElementById('image').value;
        try {
            const auth_token = localStorage.getItem('token');
            // const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch("http://127.0.0.1:8000/api/customer/carts", {
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
                // alert('Cart added Successfully');
                localStorage.setItem('cart_added', 'Cart added successfully.');
                form.reset();
                errorMessage.textContent = '';
                window.location.reload();
            }

        } catch (err) {
            console.error(err);
            errorMessage.textContent = 'An unexpected error occurred.';
        }
    });
    // });
}

// document.addEventListener('DOMContentLoaded', () => {
//     PostCartsToServer(id);
// });


function addCart(id) {
    // document.getElementById("addCartDialog").classList.remove("hidden");
    document.getElementById('addCartDialog').style.display = 'flex';
    PostCartsToServer(id);
}
function closeDialog() {
    document.getElementById('addCartDialog').style.display = 'none';
}

// Load Carts
async function loadCarts() {
    const container = document.getElementById('loadCartsView');
    if (!container) return;

    try {
        const auth_token = localStorage.getItem('token');
        const response = await fetch('http://127.0.0.1:8000/api/customer/user/carts', {
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
                added_at,
                updated_at,
                variant
            } = cart;

            const {
                size,
                color,
                material,
                sku,
                image,
                price
            } = variant;

            const formattedAddedAt = new Date(added_at).toLocaleString();
            const formattedUpdatedAt = new Date(updated_at).toLocaleString();

            const card = document.createElement('div');
            card.className = `
                variant-card opacity-0 transform translate-y-5
                transition-all duration-500 ease-out
                border rounded-lg shadow-lg p-5 bg-white w-full sm:max-w-sm
                hover:shadow-2xl hover:scale-[1.02]
            `.trim();

            card.innerHTML = `
                <img src="${image}" alt="Product Image"
                    class="w-full h-48 object-cover rounded mb-3
                    transition-transform duration-300 ease-in-out hover:scale-105">

                <h2 class="text-lg font-bold text-gray-800 mb-2">Variant Info</h2>
                <ul class="text-sm text-gray-700 space-y-1 mb-4">
                    <li><strong>SKU:</strong> ${escapeHtml(sku)}</li>
                    <li><strong>Size(s):</strong> ${escapeHtml(size)}</li>
                    <li><strong>Color(s):</strong> ${escapeHtml(color)}</li>
                    <li><strong>Material:</strong> ${escapeHtml(material)}</li>
                    <li><strong>Price:</strong> ₹${price}</li>
                </ul>

                <h2 class="text-lg font-bold text-gray-800 mb-2">Cart Info</h2>
                <ul class="text-sm text-gray-700 space-y-1 mb-4">
                    <li><strong>Quantity:</strong> ${quantity}</li>
                    <li><strong>Added At:</strong> ${formattedAddedAt}</li>
                    <li><strong>Updated At:</strong> ${formattedUpdatedAt}</li>
                </ul>

                <div class="flex gap-2">
                    <button
                        onclick="editCart(${cartId}, ${quantity})"
                        class="flex-1 px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg
                               hover:bg-blue-600 transition-all duration-300 shadow hover:shadow-md">
                        Edit Cart
                    </button>
                    <button
                        onclick="orderNow(${cartId})"
                        class="flex-1 px-4 py-2 bg-green-500 text-white font-semibold rounded-lg
                               hover:bg-green-600 transition-all duration-300 shadow hover:shadow-md">
                        Order Now
                    </button>
                </div>
            `;

            container.appendChild(card);

            setTimeout(() => {
                card.classList.remove('opacity-0', 'translate-y-5');
                card.classList.add('opacity-100', 'translate-y-0');
            }, 50);
        });

    } catch (error) {
        console.error("Failed to fetch carts:", error);
        container.innerHTML = "<p class='text-red-500'>Failed to load cart items.</p>";
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // const productId = getProductIdFromUrl();

    // if (!isNaN(productId)) {
        loadCarts();
    // } else {
    //     console.error("Invalid product ID in URL");
    //     document.getElementById('varientsGrid').innerHTML = "<p class='text-red-500'>Invalid product ID in URL.</p>";
    // }
});