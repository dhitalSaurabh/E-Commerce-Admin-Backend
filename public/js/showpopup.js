window.showPopup = function (message, type = 'success') {
    // Create container if it doesn't exist
    let container = document.getElementById('toast-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'toast-container';
        container.className = 'fixed top-5 right-5 z-50 flex flex-col items-end space-y-2';
        document.body.appendChild(container);
    }

    const notification = document.createElement('div');

    const bgClass = {
        success: 'bg-green-500',
        error: 'bg-red-500',
        info: 'bg-blue-500',
        warning: 'bg-yellow-500',
    }[type] || 'bg-gray-700';

    notification.innerText = message;
    notification.className = `${bgClass} text-white px-4 py-2 rounded shadow-md opacity-0 transition-opacity duration-300`;

    container.appendChild(notification);

    // Fade in
    setTimeout(() => {
        notification.classList.add('opacity-100');
    }, 10);

    // Fade out after 3s
    setTimeout(() => {
        notification.classList.remove('opacity-100');
        notification.classList.add('opacity-0');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
};
