document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('loginForm');

    if (!form) {
        console.error('Login form not found!');
        return;
    }

    // console.log("Login form found, adding event listener...");

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        console.log("Form submitted");

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        try {
            const response = await fetch("http://127.0.0.1:8000/api/customer/login", {
                method: "POST",
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({ email, password })
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
            }
            // ✅ Login successful
            localStorage.setItem('customer_id', data.customer.id);
            console.log(data.id);
            localStorage.setItem('token', data.token);
            localStorage.setItem('login_success', 'You have successfully logged in.');
            window.location.href = "/";

        } catch (error) {
            console.error("Network or server error:", error);
            document.getElementById('errorMessage').innerText = "An error occurred. Try again.";
        }
    });
});

