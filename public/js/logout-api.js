async function userLogout() {
    const container = document.getElementById('logoutBtn');
    if (!container) return;

    try {
        const auth_token = localStorage.getItem('auth_token');
        await fetch("http://127.0.0.1:8000/api/admin/logout", {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${auth_token}`,
            }
        });
        localStorage.removeItem('auth_token');
        localStorage.setItem('logout_message', 'You have been logged out.');
        window.location.href = '/auth/login';
    } catch (error) {
        console.error("Failed to logout:", error);
        // container.innerHTML = "<p class='text-red-500'>Failed to load clothes.</p>";
    }
}
// Load clothes when DOM is ready
// document.addEventListener('DOMContentLoaded', () => {
//     userLogout();
//     // Your form submission listener remains unchanged here...
// });
