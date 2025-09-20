
async function userLogout() {
    try {
        const auth_token = localStorage.getItem('token');
        if (!auth_token) {
            console.warn('No token found. Redirecting.');
            // window.location.href = '/';
            return;
        }

        const response = await fetch("http://127.0.0.1:8000/api/customer/logout", {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${auth_token}`,
            }
        });

        if (response.ok) {
            localStorage.removeItem('token');
            localStorage.setItem('logout_message', 'You have been logged out.');
            window.location.href = '/';
        } else {
            const errorData = await response.json();
            console.error('Logout failed:', errorData);
        }
    } catch (error) {
        console.error("Failed to logout:", error);
    }
}

// Attach to logout button
document.addEventListener('DOMContentLoaded', () => {
    document.getElementById('logoutBtn')?.addEventListener('click', userLogout);
});
