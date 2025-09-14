document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('loginForm');

    if (!form) {
        console.error('Login form not found!');
        return;
    }
    console.log("Login form found, adding event listener...");

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        console.log("Form submitted");

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        try {
            // const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch("http://127.0.0.1:8000/api/admin/login", {
                method: "POST",
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                    // "X-CSRF-TOKEN": token,
                },
                // credentials: 'include',
                body: JSON.stringify({ email, password })
            });
            console.log("Response received");
            const data = await response.json();
            console.log("Parsed response:", data);
            if (!response.ok) {
                document.getElementById('errorMessage').innerText = data.message || "Login failed";
                return;
            }

            // ✅ Store token and redirect
            localStorage.setItem('auth_token', data.token.plainTextToken);

            // Redirect to dashboard or home
            window.location.href = "/app";
        } catch (error) {
            console.error(error);
            document.getElementById('errorMessage').innerText = "An error occurred. Try again.";
        }
    });
});
