// Extract product ID from the current URL
function getProductIdFromUrl() {
    const pathSegments = window.location.pathname.split('/');
    const id = pathSegments[pathSegments.length - 1]; // Get the last segment
    return parseInt(id, 10);
}
// Load Categories

async function loadVarients(productId) {
    const container = document.getElementById('varientsGrid');
    // const productId = 
    if (!container) return;
    //  variantId =
    try {
        const response = await fetch(`http://127.0.0.1:8000/api/admin/getByProductId/${productId}`, {
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
            card.className = `
    variant-card opacity-0 transform translate-y-5
    transition-all duration-500 ease-out
    border rounded-lg shadow-lg p-5 bg-white w-full sm:max-w-sm
    hover:shadow-2xl hover:scale-[1.02]
`.trim();

            card.innerHTML = `
    <img src="${productImage}" alt="${escapeHtml(productName)}"
        class="w-full h-48 object-cover rounded mb-3
               transition-transform duration-300 ease-in-out
               hover:scale-105">

    <h2 class="text-xl font-bold mb-2 text-gray-800">${escapeHtml(productName)}</h2>

    <ul class="text-sm mb-2 space-y-1 text-gray-700">
        <li><strong>Category:</strong> ${escapeHtml(categoryName)}</li>
        <li><strong>Brand:</strong> ${escapeHtml(productBrand)}</li>
        <li><strong>Base Price:</strong> ₹${productPrice}</li>
        <li><strong>Variant Price (Extra):</strong> ₹${price}</li>
        <li><strong>SKU:</strong> ${escapeHtml(sku)}</li>
        <li><strong>Size(s):</strong> ${escapeHtml(size)}</li>
        <li><strong>Color(s):</strong> ${escapeHtml(color)}</li>
        <li><strong>Material:</strong> ${escapeHtml(material ?? 'N/A')}</li>
        <li><strong>Created At:</strong> ${formattedDate}</li>
    </ul>

    <div class="mt-3 flex gap-2">
        <a>
            <button
                class="px-4 py-2 bg-yellow-500 text-white font-semibold rounded-lg
                       shadow hover:bg-yellow-600 hover:shadow-md
                       transition-all duration-300 transform hover:scale-105"
           onClick="openDialog()" >
                Order Now
            </button>
        </a>
    </div>
`;

            // Append and animate
            container.appendChild(card);

            setTimeout(() => {
                card.classList.remove('opacity-0', 'translate-y-5');
                card.classList.add('opacity-100', 'translate-y-0');
            }, 50);

        });

    } catch (error) {
        console.error("Failed to fetch product variants:", error);
        container.innerHTML = "<p class='text-red-500'>Failed to load product variants.</p>";
    }
}
document.addEventListener('DOMContentLoaded', () => {
    const productId = getProductIdFromUrl();

    if (!isNaN(productId)) {
        loadVarients(productId);
    } else {
        console.error("Invalid product ID in URL");
        document.getElementById('varientsGrid').innerHTML = "<p class='text-red-500'>Invalid product ID in URL.</p>";
    }
});

// Load Category when DOM is ready
// document.addEventListener('DOMContentLoaded', () => {
//     loadVarients();

//     // Your form submission listener remains unchanged here...
// });

function escapeHtml(text) {
    if (typeof text !== 'string') return text;
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}