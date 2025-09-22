// Post Carts 
// document.addEventListener('DOMContentLoaded', () => {
async function PostCartsToServer(id) {
    const form = document.getElementById('AddCartForm');
    const errorMessage = document.getElementById('errorMessage');

    if (!form) return;

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(form);
        formData.append('variant_id', id);
        console.log(formData);
        // const name = document.getElementById('name').value;
        // const slug = document.getElementById('slug').value;
        // const description = document.getElementById('description').value;
        // const price = document.getElementById('price').value;
        // const image = document.getElementById('image').value;
        try {
            const auth_token = localStorage.getItem('token');
            // const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch("http://127.0.0.1:8000/api/customer/carts", {
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
                alert('Cart added Successfully');
                form.reset();
                errorMessage.textContent = '';
                // window.location.reload();
            }

        } catch (err) {
            console.error(err);
            errorMessage.textContent = 'An unexpected error occurred.';
        }
    });
    // });
}

// document.addEventListener('DOMContentLoaded', () => {
//     PostCartsToServer(id);
// });


function addCart(id) {
    // document.getElementById("addCartDialog").classList.remove("hidden");
    document.getElementById('addCartDialog').style.display = 'flex';
    PostCartsToServer(id);
}
function closeDialog() {
    document.getElementById('addCartDialog').style.display = 'none';
}