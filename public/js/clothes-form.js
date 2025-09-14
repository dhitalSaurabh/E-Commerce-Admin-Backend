document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('clothesForm');
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
            const response = await fetch("http://127.0.0.1:8000/api/admin/cloths", {
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
                alert('Clothing item added Successfully');
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
async function deleteClothingItem(id) {
    const auth_token = localStorage.getItem('auth_token');

    if (!confirm("Are you sure you want to delete this item?")) return;

    try {
        const response = await fetch(`http://127.0.0.1:8000/api/admin/cloths/${id}`, {
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
            alert("Clothing item deleted.");
            window.location.reload();
        }

    } catch (err) {
        console.error('Delete error:', err);
    }
}

// Update the clothes
async function updateClothingItem(id, updatedData) {
    const auth_token = localStorage.getItem('auth_token');

    const formData = new FormData();
    for (let key in updatedData) {
        formData.append(key, updatedData[key]);
    }

    // Laravel requires _method if we're using POST to simulate PUT
    formData.append('_method', 'PUT');

    try {
        const response = await fetch(`http://127.0.0.1:8000/api/admin/cloths/${id}`, {
            method: 'POST', // Or use PUT if your Laravel routes accept it
            headers: {
                'Accept': 'application/json',
                'Authorization': `Bearer ${auth_token}`,
            },
            body: formData
        });

        const data = await response.json();

        if (!response.ok) {
            console.error('Update failed:', data.errors);
        } else {
            alert('Clothing item updated!');
            window.location.reload();
        }

    } catch (err) {
        console.error('Update error:', err);
    }
}

