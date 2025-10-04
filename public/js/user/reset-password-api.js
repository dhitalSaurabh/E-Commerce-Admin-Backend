document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('resetPasswordForm');
    const errorMessage = document.getElementById('errorMessage')

    if (!form) {
        console.error('Login form not found!');
        return;
    }

    // console.log("Login form found, adding event listener...");

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

    const formData = new FormData(form);
    console.log(formData);

        try {
            const auth_token = localStorage.getItem('token');
            const response = await fetch("http://127.0.0.1:8000/api/customer/reset-password", {
                method: "POST",
                headers: {
                    "Accept": "application/json",
                    'Authorization': `Bearer ${auth_token}`,
                },
                body: formData,
            });

            const raw = await response.text();
            let data;

            try {
                data = JSON.parse(raw);
            } catch (parseError) {
                console.error("Non-JSON response received:", raw);
                document.getElementById('errorMessage').innerText = "Unexpected server error.";
                return;
            }

            if (!response.ok) {
                console.warn("API returned an error:", data);
                document.getElementById('errorMessage').innerText = data.message || "Login failed";
                return;
            } else {
                // ✅ Login successful
                localStorage.setItem('password_reset', 'You have successfully reset password.');
                // localStorage.setItem('customer_id', data.customer.id);
                window.location.href = "/";
            }
        } catch (error) {
            console.error("Network or server error:", error);
            document.getElementById('errorMessage').innerText = "An error occurred. Try again.";
        }
    });
});

