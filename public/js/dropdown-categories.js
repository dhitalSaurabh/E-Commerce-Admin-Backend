
    async function loadCategories() {
        const select = document.getElementById('category_id');
        if (!select) return;

        try {
            const response = await fetch("http://127.0.0.1:8000/api/admin/categories", {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                }
            });

            const categories = await response.json();
            console.log("API Response:", categories); // 🔍 Add this
            // const categories = result.data;

            if (!Array.isArray(categories)) {
                console.error("Expected array, got:", categories);
                return;
            }

            // Clear existing options (except the first one)
            select.innerHTML = '<option value="">Select a Category</option>';

            categories.forEach(cat => {
                const option = document.createElement('option');
                option.value = cat.id;
                option.textContent = cat.name;
                select.appendChild(option);
            });

        } catch (error) {
            console.error("Failed to load categories:", error);
        }
    }

    // Load on DOM ready
    document.addEventListener('DOMContentLoaded', () => {
        loadCategories();
    });

