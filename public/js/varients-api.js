// Load Categories
async function loadVarients() {
    const container = document.getElementById('varientsGrid');
    if (!container) return;

    try {
        const response = await fetch("http://127.0.0.1:8000/api/admin/productVarients", {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        });

        const result = await response.json();
        const variants = result.data;
        container.innerHTML = ''; // Clear grid

        if (!Array.isArray(variants)) {
            console.error("Expected array, got:", variants);
            return;
        }

        if (variants.length === 0) {
            container.innerHTML = '<p>No variants found.</p>';
            return;
        }

        variants.forEach(variant => {
            const {
                id,
                size,
                color,
                material,
                price,
                sku,
                image,
                created_at,
                product
            } = variant;

            const formattedDate = new Date(created_at).toLocaleDateString('en-GB'); // dd/mm/yyyy
            const productId = product?.id ?? 0;
            const productName = product?.name ?? 'Unnamed';
            const productPrice = price ?? 'N/A';
            const productBrand = product?.brand ?? 'N/A';
            const productImage = image ?? '';
            const categoryName = product?.category?.name ?? 'Uncategorized';

            const card = document.createElement('div');
            card.className = 'border rounded shadow p-4 bg-white max-w-sm';

            card.innerHTML = `
                <img src="${productImage}" alt="${escapeHtml(productName)}" class="w-full h-48 object-cover rounded mb-3">

                <h2 class="text-xl font-bold">${escapeHtml(productName)}</h2>

                <ul class="text-sm mb-2 space-y-1">
                    <li><strong>Category:</strong> ${escapeHtml(categoryName)}</li>
                    <li><strong>Brand:</strong> ${escapeHtml(productBrand)}</li>
                    <li><strong>Base Price:</strong> ₹${productPrice}</li>
                    <li><strong>Variant Price (Extra):</strong> Rs.${price}</li>
                    <li><strong>SKU:</strong> ${escapeHtml(sku)}</li>
                    <li><strong>Size(s):</strong> ${escapeHtml(size)}</li>
                    <li><strong>Color(s):</strong> ${escapeHtml(color)}</li>
                    <li><strong>Material:</strong> ${escapeHtml(material ?? 'N/A')}</li>
                    <li><strong>Created At:</strong> ${formattedDate}</li>
                </ul>

                <div class="mt-3 flex gap-2">
                    <button
                        class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                        onclick="openEditDialog(${id},${productId},'${escapeHtml(size)}','${escapeHtml(color)}','${escapeHtml(material)}',${price}, '${escapeHtml(sku)}')"
                    >Edit</button>
                    <button
                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                        onclick='deleteVariantItem(${id})'
                    >Delete</button>
                </div>
            `;

            container.appendChild(card);
        });

    } catch (error) {
        console.error("Failed to fetch product variants:", error);
        container.innerHTML = "<p class='text-red-500'>Failed to load product variants.</p>";
    }
}


// Load Category when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    loadVarients();

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
    const form = document.getElementById('varientsForm');
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
            const response = await fetch("http://127.0.0.1:8000/api/admin/productVarients", {
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
async function deleteVariantItem(id) {
    const auth_token = localStorage.getItem('auth_token');

    if (!confirm("Are you sure you want to delete this Category?")) return;

    try {
        const response = await fetch(`http://127.0.0.1:8000/api/admin/productVarients/${id}`, {
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
async function updateVarientItem(id, updatedData) {
    const auth_token = localStorage.getItem('auth_token');

    const formData = new FormData();
    for (let key in updatedData) {
        formData.append(key, updatedData[key]);
    }

    // Laravel requires _method if we're using POST to simulate PUT
    formData.append('_method', 'PUT');

    try {
        const response = await fetch(`http://127.0.0.1:8000/api/admin/productVarients/${id}`, {
            method: 'POST', // Or use PUT if your Laravel routes accept it
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${auth_token}`,
            },
            body: formData
        });

        const data = await response.json();
        console.log(data);
        if (response.status == 200 || response.status == 201) {

            alert('Category item updated!');
            window.location.reload();
        } else {
            console.error('Update failed:', data.errors);
        }

    } catch (err) {
        console.error('Update error:', err);
    }
}

