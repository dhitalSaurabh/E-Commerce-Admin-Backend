document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('registerForm');

    if (!form) {
        console.error('Register form not found!');
        return;
    }
    console.log("Register form found, adding event listener...");

    form.addEventListener('submit', async function (e) {
        e.preventDefault();
        console.log("Form submitted");
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const password_confirmation = document.getElementById('password_confirmation').value;

        try {
            // const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch("http://127.0.0.1:8000/api/customer/registers", {
                method: "POST",
                headers: {
                    "Accept": "application/json",
                    "Content-Type": "application/json",
                    // "X-CSRF-TOKEN": token,
                },
                // credentials: 'include',
                body: JSON.stringify({ name, email, password, password_confirmation })
            });
            console.log("Response received");
            const data = await response.json();
            console.log("Parsed response:", data);
            if (!response.ok) {
                document.getElementById('errorMessage').innerText = data.message || "Registration Failed";
                return;
            }

            // // ✅ Store token and redirect
            // localStorage.setItem('auth_token', data.token.plainTextToken);
 localStorage.setItem('register_success', 'You have registered successfully, proceed to login.');
            // Redirect to dashboard or home
            window.location.href = "/authuser/login";
        } catch (error) {
            console.error(error);
            document.getElementById('errorMessage').innerText = "An error occurred. Try again.";
        }
    });
});
