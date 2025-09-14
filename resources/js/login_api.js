
document.getElementById('loginForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;

    try {
        const response = await fetch("{{ url('/api/admin/login') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
            },
            body: JSON.stringify({ email, password })
        });

        const data = await response.json();

        if (!response.ok) {
            document.getElementById('errorMessage').innerText = data.message || "Login failed";
            return;
        }

        // ✅ Store token and redirect
        localStorage.setItem('auth_token', data.token);

        // Redirect to dashboard or home
        window.location.href = "{{ url('/dashboard') }}";
    } catch (error) {
        console.error(error);
        document.getElementById('errorMessage').innerText = "An error occurred. Try again.";
    }
});

