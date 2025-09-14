// Load Categories
async function loadCategories() {
    const container = document.getElementById('categoriesGrid');
    if (!container) return;

    try {
        const response = await fetch("http://127.0.0.1:8000/api/admin/categories", {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
            }
        });

        const categories = await response.json();
        container.innerHTML = ''; // Clear grid

        if (!Array.isArray(categories)) {
            console.error("Expected array, got:", categories);
            return;
        }

        if (categories.length === 0) {
            container.innerHTML = '<p>No categories found.</p>';
            return;
        }

        categories.forEach(item => {
            const id = item.id ?? 0;
            const name = item.name ?? 'Unnamed';
            // const parent_id = item.parent_id ?? null;

            const card = document.createElement('div');
            card.className = 'border rounded shadow p-4 bg-white';

            card.innerHTML = `
                <h2 class="text-lg font-bold">${escapeHtml(name)}</h2>

                <div class="mt-3 flex gap-2">
                    <button
                        class="px-3 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600"
                        onclick="openEditDialog(${item.id}, '${item.name}')"
                    >Edit</button>

                    <button
                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                        onclick='deleteCategoryItem(${id})'
                    >Delete</button>
                </div>
            `;

            container.appendChild(card);
        });

    } catch (error) {
        console.error("Failed to fetch clothes:", error);
        container.innerHTML = "<p class='text-red-500'>Failed to load clothes.</p>";
    }
}

// Load Category when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    loadCategories();

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
// Post Categories 
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('categoriesForm');
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
            const response = await fetch("http://127.0.0.1:8000/api/admin/categories", {
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
                alert('Category item added Successfully');
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
async function deleteCategoryItem(id) {
    const auth_token = localStorage.getItem('auth_token');

    if (!confirm("Are you sure you want to delete this Category?")) return;

    try {
        const response = await fetch(`http://127.0.0.1:8000/api/admin/categories/${id}`, {
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
async function updateCategoryItem(id, updatedData) {
    const auth_token = localStorage.getItem('auth_token');

    const formData = new FormData();
    for (let key in updatedData) {
        formData.append(key, updatedData[key]);
    }

    // Laravel requires _method if we're using POST to simulate PUT
    formData.append('_method', 'PUT');

    try {
        const response = await fetch(`http://127.0.0.1:8000/api/admin/categories/${id}`, {
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

