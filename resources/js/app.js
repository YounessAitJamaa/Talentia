import './bootstrap';
// ecouter 
// import Alpine from 'alpinejs';

// window.Alpine = Alpine;

// Alpine.start();

window.Echo.private('user-status.' + userId) // userId = ID de l'utilisateur connecté
    .listen('UserStatusUpdated', (event) => {
        if (event.status === 'online') {
            document.getElementById('status-indicator').classList.add('bg-green-500');
            document.getElementById('status-indicator').classList.remove('bg-gray-500');
        } else {
            document.getElementById('status-indicator').classList.add('bg-gray-500');
            document.getElementById('status-indicator').classList.remove('bg-green-500');
        }
    });
