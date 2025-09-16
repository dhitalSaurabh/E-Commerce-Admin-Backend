// Load Inventory
async function loadInventory() {
    const container = document.getElementById('inventoryGrid');
    if (!container) return;

    try {
        const response = await fetch("http://127.0.0.1:8000/api/admin/inventories", {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        });

        const result = await response.json();
        const stocks = result.data;
        container.innerHTML = ''; // Clear grid

        if (!Array.isArray(stocks)) {
            console.error("Expected array, got:", stocks);
            return;
        }

        if (stocks.length === 0) {
            container.innerHTML = '<p>No stocks found.</p>';
            return;
        }

        stocks.forEach(item => {
            const {
                id,
                stock_quantity,
                created_at,
                variant
            } = item;

            const variantName = `Variant #${variant?.id ?? 'N/A'}`;
            const variantId = `${variant?.id ?? 0}`;

            const size = variant?.size ?? 'N/A';
            const color = variant?.color ?? 'N/A';
            const variantSku = variant?.sku ?? 'N/A';
            const additionalPrice = variant?.additional_price ?? 0;

            const product = variant?.product ?? {};
            const name = product.name ?? 'Unnamed Product';
            const description = product.description ?? '';
            const price = product.price ?? 0;
            const brand = product.brand ?? 'Unknown';
            const sku = product.sku ?? 'N/A';
            const image = product.image ?? '';
            const formattedDate = new Date(created_at).toLocaleDateString('en-GB'); // dd/mm/yyyy

            const card = document.createElement('div');
            card.className = 'border rounded shadow p-4 bg-white max-w-sm';

            card.innerHTML = `
                <img src="${image}" alt="${escapeHtml(name)}" class="w-full h-48 object-cover rounded mb-3">

                <h2 class="text-xl font-bold">${escapeHtml(name)}</h2>
                <p class="text-sm text-gray-600 mb-2">${escapeHtml(description)}</p>

                <ul class="text-sm mb-3 space-y-1">
                    <li><strong>Stock Quantity:</strong> ${stock_quantity}</li>
                    <li><strong>Created Date:</strong> ${formattedDate}</li>
                    <li><strong>Variant Name:</strong> ${escapeHtml(variantName)}</li>
                    <li><strong>Size:</strong> ${escapeHtml(size)}</li>
                    <li><strong>Color:</strong> ${escapeHtml(color)}</li>
                    <li><strong>Variant SKU:</strong> ${escapeHtml(variantSku)}</li>
                    <li><strong>Additional Price:</strong> ₹${additionalPrice}</li>
                    <li><strong>Product Price:</strong> ₹${price}</li>
                    <li><strong>Brand:</strong> ${escapeHtml(brand)}</li>
                    <li><strong>Product SKU:</strong> ${escapeHtml(sku)}</li>
                </ul>

                <div class="mt-3 flex gap-2">
                    <button
                        class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                        onclick="openEditDialog(${id},${variantId}, ${stock_quantity})"
                    >Edit</button>

                    <button
                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                        onclick='deleteInventoryItem(${id})'
                    >Delete</button>
                </div>
            `;

            container.appendChild(card);
        });

    } catch (error) {
        console.error("Failed to fetch stocks:", error);
        container.innerHTML = "<p class='text-red-500'>Failed to load stocks.</p>";
    }
}



// Load Inventory when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    loadInventory();

    // Your form submission listener remains unchanged here...
});

function escapeHtml(text) {
    if (typeof text !== 'string') return text;
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}
// Post Inventory 
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('InventoryForm');
    const errorMessage = document.getElementById('errorMessage');

    if (!form) return;

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        console.log(formData);
        try {
            const auth_token = localStorage.getItem('auth_token');
            // const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch("http://127.0.0.1:8000/api/admin/inventories", {
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
                alert('Stock added Successfully');
                form.reset();
                errorMessage.textContent = '';
                window.location.reload();
            }

        } catch (err) {
            console.error(err);
            errorMessage.textContent = 'An unexpected error occurred.';
        }
    });
});

// Delete Inventory
async function deleteInventoryItem(id) {
    const auth_token = localStorage.getItem('auth_token');

    if (!confirm("Are you sure you want to delete this Stock?")) return;

    try {
        const response = await fetch(`http://127.0.0.1:8000/api/admin/inventories/${id}`, {
            method: 'DELETE',
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${auth_token}`,
            }
        });

        if (!response.ok) {
            const data = await response.json();
            alert(data.message || 'Failed to delete.');
        } else {
            alert("Stock item deleted.");
            window.location.reload();
        }

    } catch (err) {
        console.error('Delete error:', err);
    }
}

// Update the Inventory
async function updateInventoryItem(id, updatedData) {
    const auth_token = localStorage.getItem('auth_token');

    const formData = new FormData();
    for (let key in updatedData) {
        formData.append(key, updatedData[key]);
    }

    // Laravel requires _method if we're using POST to simulate PUT
    formData.append('_method', 'PUT');

    try {
        const response = await fetch(`http://127.0.0.1:8000/api/admin/inventories/${id}`, {
            method: 'POST', // Or use PUT if your Laravel routes accept it
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${auth_token}`,
            },
            body: formData
        });

        const data = await response.json();

        if (!response.status == 200 || response.status == 201) {
            console.error('Update failed:', data.errors);
        } else {
            alert('Inventory item updated!');
            window.location.reload();
        }

    } catch (err) {
        console.error('Update error:', err);
    }
}

