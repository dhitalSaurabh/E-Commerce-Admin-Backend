// Load Categories
async function loadProducts() {
    const container = document.getElementById('productsGrid');
    if (!container) return;

    // Show loading spinner while data is being fetched
    container.innerHTML = '<div class="w-12 h-12 border-4 border-t-4 border-blue-500 border-solid rounded-full animate-spin mx-auto"></div>';

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
            container.innerHTML = '<p class="text-center text-gray-500">No products found.</p>';
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
            card.className = 'product-card border rounded-lg shadow-lg p-4 bg-white max-w-sm opacity-0 transform translate-y-5 transition-all duration-500 ease-out hover:scale-105 hover:shadow-xl'; // Card hover effects

            card.innerHTML = `
                <img src="${image}" alt="${escapeHtml(name)}" class="w-full h-48 object-cover rounded mb-3 transition-transform duration-300 ease-in-out transform hover:scale-105">

                <h2 class="text-xl font-bold mb-2 text-gray-800 transition-opacity duration-300 opacity-0">${escapeHtml(name)}</h2>

                <p class="text-sm text-gray-600 mb-2 transition-opacity duration-300 opacity-0">${escapeHtml(description)}</p>

                <ul class="text-sm mb-3 space-y-1">
                    <li><strong>Price:</strong> ₹${price}</li>
                    <li><strong>Brand:</strong> ${escapeHtml(brand)}</li>
                    <li><strong>SKU:</strong> ${escapeHtml(sku)}</li>
                    <li><strong>Category:</strong> ${escapeHtml(categoryName)}</li>
                    <li><strong>Created:</strong> ${formattedDate}</li>
                </ul>

                <div class="mt-3 flex gap-2 opacity-0 transition-opacity duration-300">
                    <button
                        class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition-all duration-300 transform hover:scale-105"
                        onclick="openOrderDialog(${id})"
                    >Order Now</button>

                    <a href="/variants/${id}"><button
                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition-all duration-300 transform hover:scale-105"
                        
                    >Check Variants</button></a>
                </div>
            `;

            // Append card to container
            container.appendChild(card);

            // Trigger the fade-in animation after appending the card
            setTimeout(() => {
                card.classList.add('opacity-100', 'translate-y-0');

                // Animate the inner content (name, description, buttons) to fade in
                const cardContent = card.querySelectorAll('.transition-opacity');
                cardContent.forEach(el => el.classList.add('opacity-100'));
            }, 50);
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

function checkIfUserLoggedIn() {
    const auth_token = localStorage.getItem('token');
    if (!auth_token) {
        window.location.href = '/authuser/login';
        return false;
    }
    return true;
}

async function openOrderDialog(id) {
    if (!checkIfUserLoggedIn()) {
        return;
    }

    const hasAddress = await checkUserAddress();
    if (!hasAddress) {
        document.getElementById('userAddressDialog').style.display = 'flex';
    } else if (hasAddress) {
        localStorage.setItem('select_variants', 'Please select the variant to order now. ');
        window.location.href = '/variants/' + id;
    } else {
        console.log("User has already filled the address form.");
    }
}

function closeOrderDialog() {
    document.getElementById('userAddressDialog').style.display = 'none';
}