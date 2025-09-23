
// Post User Address 
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('userAddressForm');
    const errorMessage = document.getElementById('errorMessage');
    // if (checkIfUserLoggedIn == false)
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
            const auth_token = localStorage.getItem('token');
            // const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch("http://127.0.0.1:8000/api/customer/userAddress", {
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
                alert('user address added Successfully');
                form.reset();
                errorMessage.textContent = '';
                // window.location.reload();
            }

        } catch (err) {
            console.error(err);
            errorMessage.textContent = 'An unexpected error occurred.';
        }
    });
});
// Checks if user already filled the form.
async function checkUserAddress() {
    console.log("function called");
    try {
        const response = await fetch('http://127.0.0.1:8000/api/customer/auth/userAddress', {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${localStorage.getItem('token')}`,
            }
        });

        const data = await response.json();
        console.log("Response" + data);
        // Assuming the API returns an object with a field 'addressFilled' (boolean)
        if (data.data && data.data.addressFilled) {
            return true; // Address already filled
        } else {
            return false; // Address not filled
        }
    } catch (error) {
        console.error('Error checking address:', error);
        return false; // Default to false if error occurs
    }
}
//  / 
function checkIfUserLoggedIn() {
    const auth_token = localStorage.getItem('token');
    if (!auth_token) {
        window.location.href = '/authuser/login';
        return false;
    }
    return true;
}

function openDialog(id, productName, price) {

    if (!checkIfUserLoggedIn()) {
        return;
    }
    // Example condition — replace this with real logic (e.g., from server or JS state)
    const hasAddress = true; // or false

    document.getElementById('dialogContainer').classList.remove('hidden');

    if (hasAddress) {
        document.getElementById('dialogA').classList.remove('hidden');
        document.getElementById('dialogB').classList.add('hidden');
    } else {
        document.getElementById('dialogA').classList.add('hidden');
        document.getElementById('dialogB').classList.remove('hidden');
    }
    document.getElementById('variant_id').value = id;
    document.getElementById('price').value = price;
    const quantityInput = document.getElementById('quantity');
    const totalAmountInput = document.getElementById('total_amount');

    // Initialize total
    const initialQty = parseInt(quantityInput.value) || 0;
    totalAmountInput.value = initialQty * price;

    // Live update on quantity change
    quantityInput.oninput = function () {
        const q = parseInt(this.value) || 0;
        totalAmountInput.value = q * price;
    };
}

function closeDialogContainer() {
    document.getElementById('dialogContainer').classList.add('hidden');
    document.getElementById('dialogA').classList.add('hidden');
    document.getElementById('dialogB').classList.add('hidden');
}

