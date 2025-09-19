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