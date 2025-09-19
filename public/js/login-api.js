// document.addEventListener('DOMContentLoaded', function () {
//     const form = document.getElementById('loginForm');

//     if (!form) {
//         console.error('Login form not found!');
//         return;
//     }
//     console.log("Login form found, adding event listener...");

//     form.addEventListener('submit', async function (e) {
//         e.preventDefault();
//         console.log("Form submitted");

//         const email = document.getElementById('email').value;
//         const password = document.getElementById('password').value;

//         try {
//             // const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
//             const response = await fetch("http://127.0.0.1:8000/api/admin/login", {
//                 method: "POST",
//                 headers: {
//                     "Accept": "application/json",
//                     "Content-Type": "application/json",
//                     // "X-CSRF-TOKEN": token,
//                 },
//                 // credentials: 'include',
//                 body: JSON.stringify({ email, password })
//             });
//             // console.log("Response received");
//             const data = await response.json();
//             // console.log("Parsed response:", data);
//             if (!response.ok) {
//                 document.getElementById('errorMessage').innerText = data.message || "Login failed";
//                 return;
//             }

//             // ✅ Store token and redirect
//             localStorage.setItem('auth_token', data.token);

//             localStorage.setItem('login_success', 'You have successfully logged in.');
//             // Redirect to dashboard or home
//             // window.location.href = "/app";
//         } catch (error) {
//             console.error(error);
//             document.getElementById('errorMessage').innerText = "An error occurred. Try again.";
//         }
//     });
// });
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
            const response = await fetch("http://127.0.0.1:8000/api/admin/login", {
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
            localStorage.setItem('auth_token', data.token);
            localStorage.setItem('login_success', 'You have successfully logged in.');
            window.location.href = "/app";

        } catch (error) {
            console.error("Network or server error:", error);
            document.getElementById('errorMessage').innerText = "An error occurred. Try again.";
        }
    });
});

