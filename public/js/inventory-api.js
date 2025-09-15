// Load Categories
async function loadProducts() {
    const container = document.getElementById('productsGrid');
    if (!container) return;

    try {
        const response = await fetch("http://127.0.0.1:8000/api/admin/products", {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        });

        const result = await response.json();
        const products = result.data;
        container.innerHTML = ''; // Clear grid

        if (!Array.isArray(products)) {
            console.error("Expected array, got:", products);
            return;
        }

        if (products.length === 0) {
            container.innerHTML = '<p>No products found.</p>';
            return;
        }

        products.forEach(item => {
            const {
                id,
                name,
                image,
                description,
                price,
                brand,
                sku,
                created_at,
                category
            } = item;

            const categoryName = category?.name ?? 'Uncategorized';
            const categoryId = category?.id ?? 0;
            const formattedDate = new Date(created_at).toLocaleDateString('en-US'); // MM/DD/YY format

            const card = document.createElement('div');
            card.className = 'border rounded shadow p-4 bg-white max-w-sm';

            card.innerHTML = `
                <img src="${image}" alt="${escapeHtml(name)}" class="w-full h-48 object-cover rounded mb-3">

                <h2 class="text-xl font-bold">${escapeHtml(name)}</h2>

                <p class="text-sm text-gray-600 mb-2">${escapeHtml(description)}</p>

                <ul class="text-sm mb-3 space-y-1">
                    <li><strong>Price:</strong> ₹${price}</li>
                    <li><strong>Brand:</strong> ${escapeHtml(brand)}</li>
                    <li><strong>SKU:</strong> ${escapeHtml(sku)}</li>
                    <li><strong>Category:</strong> ${escapeHtml(categoryName)}</li>
                    <li><strong>Created:</strong> ${formattedDate}</li>
                </ul>

                <div class="mt-3 flex gap-2">
                    <button
                        class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                        onclick="openEditDialog(${id}, '${escapeHtml(name)}', '${escapeHtml(description)}', ${price}, '${escapeHtml(brand)}', '${escapeHtml(sku)}', ${categoryId})"
                    >Edit</button>

                    <button
                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                        onclick='deleteProductItem(${id})'
                    >Delete</button>
                </div>
            `;

            container.appendChild(card);
        });

    } catch (error) {
        console.error("Failed to fetch products:", error);
        container.innerHTML = "<p class='text-red-500'>Failed to load products.</p>";
    }
}


// Load Category when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    loadProducts();

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
// Post Products 
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('productsForm');
    const errorMessage = document.getElementById('errorMessage');

    if (!form) return;

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        console.log(formData);
        // const name = document.getElementById('name').value;
        // const slug = document.getElementById('slug').value;
        // const description = document.getElementById('description').value;
        // const price = document.getElementById('price').value;
        // const image = document.getElementById('image').value;
        try {
            const auth_token = localStorage.getItem('auth_token');
            // const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch("http://127.0.0.1:8000/api/admin/products", {
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
                alert('Product added Successfully');
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

// Delete clothes
async function deleteProductItem(id) {
    const auth_token = localStorage.getItem('auth_token');

    if (!confirm("Are you sure you want to delete this Category?")) return;

    try {
        const response = await fetch(`http://127.0.0.1:8000/api/admin/products/${id}`, {
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
            alert("Category item deleted.");
            window.location.reload();
        }

    } catch (err) {
        console.error('Delete error:', err);
    }
}

// Update the clothes
async function updateProductItem(id, updatedData) {
    const auth_token = localStorage.getItem('auth_token');

    const formData = new FormData();
    for (let key in updatedData) {
        formData.append(key, updatedData[key]);
    }

    // Laravel requires _method if we're using POST to simulate PUT
    formData.append('_method', 'PUT');

    try {
        const response = await fetch(`http://127.0.0.1:8000/api/admin/products/${id}`, {
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
            alert('Category item updated!');
            window.location.reload();
        }

    } catch (err) {
        console.error('Update error:', err);
    }
}

