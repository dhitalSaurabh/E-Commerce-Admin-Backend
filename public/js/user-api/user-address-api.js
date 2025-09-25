
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
            // console.log(cu)
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


// Loads User Address
async function loadUserAddress() {
    const id = localStorage.getItem('customer_id');
    const token = localStorage.getItem('token');

    console.log(id);
    const container = document.getElementById('userAddressGrid');
    if (!container) return;
    console.log(id);
    try {
        const response = await fetch(`http://127.0.0.1:8000/api/customer/userAddress/${id}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`,
            }
        });

        const result = await response.json();

        container.innerHTML = ''; // Clear previous content

        // Validate response
        if (!result || !result.data) {
            container.innerHTML = '<p class="text-red-500">User address not found.</p>';
            return;
        }

        const address = result.data;
        const customer = address.customer;

        // Create UI card
        const card = document.createElement('div');
        card.className = 'border rounded shadow p-4 bg-white max-w-md';

        card.innerHTML = `
            <h2 class="text-xl font-bold mb-2">User Address</h2>
            <p><strong>Customer ID:</strong> ${address.customer_id}</p>
            <p><strong>Full Name:</strong> ${address.full_name}</p>
            <p><strong>Phone:</strong> ${address.phone}</p>
            <p><strong>City:</strong> ${address.city}</p>
            <p><strong>State:</strong> ${address.state}</p>
            <hr class="my-3">
            <h3 class="text-lg font-semibold">Customer Info</h3>
            <p><strong>Email:</strong> ${customer.email}</p>
            <p><strong>Email Verified:</strong> ${customer.email_verified_at ? 'Yes' : 'No'}</p>
            <button class = "w-full text-center px-6 py-2 text-sm text-white bg-blue-500 hover:bg-blue-800" 
            onclick="EditUserInfo()"
            >Edit Information</button>
        `;

        container.appendChild(card);

    } catch (error) {
        console.error("Failed to load user address:", error);
        container.innerHTML = "<p class='text-red-500'>Failed to load user address.</p>";
    }
}

// Call the function on DOM load
document.addEventListener('DOMContentLoaded', () => {
    loadUserAddress();
});