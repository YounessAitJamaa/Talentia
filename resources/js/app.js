import './bootstrap';
// ecouter 
// import Alpine from 'alpinejs';

// window.Alpine = Alpine;

// Alpine.start();



window.Echo.private('user-status.' + userId)
    .listen('UserStatusUpdated', (event) => {
        const statusIndicator = document.querySelector(`#user-${event.userId} .status-indicator`);
        const statusText = document.querySelector(`#user-${event.userId} .status-text`);

        if (event.status === 'online') {
            statusIndicator.classList.add('bg-green-500');
            statusIndicator.classList.remove('bg-gray-500');
            statusText.textContent = 'En ligne';
        } else {
            statusIndicator.classList.add('bg-gray-500');
            statusIndicator.classList.remove('bg-green-500');
            statusText.textContent = 'Hors ligne';
        }
    });
