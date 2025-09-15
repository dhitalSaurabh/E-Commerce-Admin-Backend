
async function loadProducts(productId = 'product_id') {
    const select = document.getElementById(productId);
    if (!select) return;

    try {
        const response = await fetch("http://127.0.0.1:8000/api/admin/products", {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        });

        const result = await response.json();
        console.log("API Response:", result); // 🔍 Add this
        const products = result.data;

        if (!Array.isArray(products)) {
            console.error("Expected array, got:", products);
            return;
        }

        // Clear existing options (except the first one)
        select.innerHTML = '<option value="">Select a Product</option>';

        products.forEach(product => {
            const option = document.createElement('option');
            option.value = product.id;
            option.textContent = product.name;
            select.appendChild(option);
        });

    } catch (error) {
        console.error("Failed to load products:", error);
    }
}

// Load on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    loadProducts("product_id");
    loadProducts("editProductId");

});

