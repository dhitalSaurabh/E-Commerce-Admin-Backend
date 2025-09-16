
async function loadVarients(variantId = 'variant_id') {
    const select = document.getElementById(variantId);
    if (!select) return;

    try {
        const response = await fetch("http://127.0.0.1:8000/api/admin/productVarients", {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        });

        const result = await response.json();
        console.log("API Response:", result); // 🔍 Add this
        const variant = result.data;

        if (!Array.isArray(variant)) {
            console.error("Expected array, got:", variant);
            return;
        }

        // Clear existing options (except the first one)
        select.innerHTML = '<option value="">Select a Product variant</option>';

        variant.forEach(variant => {
            const option = document.createElement('option');
            option.value = variant.id;
            option.textContent = variant.sku;
            select.appendChild(option);
        });

    } catch (error) {
        console.error("Failed to load variants:", error);
    }
}

// Load on DOM ready
document.addEventListener('DOMContentLoaded', () => {
    loadVarients("variant_id");
    loadVarients("editVarientId");

});

