async function loadClothes() {
    const container = document.getElementById('clothesGrid');
    if (!container) return;

    try {
        const response = await fetch("http://127.0.0.1:8000/api/admin/cloths", {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        });

        const clothes = await response.json();
        container.innerHTML = ''; // Clear grid

        // Add this check:
        if (!Array.isArray(clothes)) {
            console.error("Expected array, got:", clothes);
            return;
        }

        if (clothes.length === 0) {
            container.innerHTML = '<p>No clothes found.</p>';
            return;
        }

        clothes.forEach(item => {
            const card = document.createElement('div');
            card.className = 'border rounded shadow p-4 bg-white';

            card.innerHTML = `
                <img src="${item.image}" alt="${item.name}" height= "300" width = "300" class="w-full h-48 object-cover rounded mb-2">
                <h2 class="text-lg font-bold">${item.name}</h2>
                <p class="text-sm text-gray-600">${item.description}</p>
                <p class="text-green-600 font-semibold mt-2">$${item.price}</p>
                <div class="mt-3 flex gap-2">
                <button onclick="openEditDialog(${item.id}, '${item.name}', '${item.slug}', '${item.description}', ${item.price})"
                class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600">Edit</button>
                <button onclick="deleteClothingItem(${item.id})"
                class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700">Delete</button>
                </div>
                `;

            container.appendChild(card);
        });

    } catch (error) {
        console.error("Failed to fetch clothes:", error);
        container.innerHTML = "<p class='text-red-500'>Failed to load clothes.</p>";
    }
}

// Load clothes when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    loadClothes();

    // Your form submission listener remains unchanged here...
});
