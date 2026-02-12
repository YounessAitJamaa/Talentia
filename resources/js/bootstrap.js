import axios from 'axios';
import Echo from 'laravel-echo';

window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Echo = new Echo({
    broadcaster: 'reverb',
    // key: 'local',
    // wsHost: '127.0.0.1',
    // wsPort: 8080,
    // forceTLS: false,
    // encrypted: false,
    // enabledTransports: ['ws'],
});

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allow your team to quickly build robust real-time web applications.
 */

import './echo';
