import './bootstrap';

const userId = document.querySelector('meta[name="user-id"]')?.content;
window.userId = userId; // Make userId globally available for addMessage

if (userId && window.Echo) {
    console.log(`Subscribing to private channel for user ${userId}`);

    window.Echo.private(`chat.${userId}`)
        .listen('.message.sent', (e) => {
            console.log(e.message.content);
            addMessage(e.message); // Call the new addMessage with the full message object
        })
        .error((error) => {
            console.log('Error subscribing to private channel:', error);
        });

    // Listen for friend request notifications on a public channel
    window.Echo.channel(`user.${userId}`)
        .listen('.friend.request.sent', (e) => {
            console.log('Friend request received:', e);
            showNotification(e.sender.name + " sent you a friend request!");
        });
}

const addMessage = (message) => {
    const chatMessages = document.getElementById('chat-messages');
    if (!chatMessages) return;

    // Check if the current chat window matches the message sender (or we are the sender)
    const currentPartnerId = chatMessages.getAttribute('data-chat-partner-id');
    const authId = window.userId; // Defined in app.blade.php

    if (message.sender_id != currentPartnerId && message.sender_id != authId) {
        return; // Don't add messages for other conversations
    }

    const isSent = message.sender_id == authId;
    const time = new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });

    let html = '';
    if (isSent) {
        html = `
            <div class="flex justify-end animate-fade-in-up">
                <div class="max-w-[70%] rounded-2xl px-4 py-2 bg-blue-600 text-white shadow-sm">
                    <p class="text-sm">${message.content}</p>
                    <p class="text-[10px] mt-1 text-blue-100 text-right">${time}</p>
                </div>
            </div>
        `;
    } else {
        html = `
            <div class="flex justify-start animate-fade-in-up">
                <div class="max-w-[70%] rounded-2xl px-4 py-2 bg-white border border-gray-100 text-gray-900 shadow-sm">
                    <p class="text-sm font-semibold text-gray-800 mb-0.5">${message.sender ? message.sender.name : 'Unknown'}</p>
                    <p class="text-sm">${message.content}</p>
                    <p class="text-[10px] mt-1 text-gray-500">${time}</p>
                </div>
            </div>
        `;
    }

    chatMessages.insertAdjacentHTML('beforeend', html);
    chatMessages.scrollTop = chatMessages.scrollHeight;
};


function applyStatus(userId, status) {
    const isOnline = status === 'online';

    document.querySelectorAll(`[data-status-dot="${userId}"]`).forEach(el => {
        el.classList.toggle('bg-green-500', isOnline);
        el.classList.toggle('bg-gray-500', !isOnline);
    });

    document.querySelectorAll(`[data-status-text="${userId}"]`).forEach(el => {
        el.textContent = isOnline ? 'En ligne' : 'Hors ligne';
        el.classList.toggle('text-green-600', isOnline);
        el.classList.toggle('text-gray-500', !isOnline);
    });
}

window.Echo.channel('user-status')
    .listen('.user.status.updated', (e) => {
        console.log('Status updated event received:', e);
        applyStatus(String(e.userId), e.status);
    });

function showNotification(message) {
    let container = document.getElementById('notification-container');
    if (!container) {
        container = document.createElement('div');
        container.id = 'notification-container';
        container.className = 'fixed top-5 right-5 z-50 space-y-3';
        document.body.appendChild(container);
    }
    const notification = document.createElement('div');
    notification.className = 'bg-white shadow-xl border border-gray-200 rounded-lg px-4 py-3 flex items-start gap-3 animate-slide-in';
    notification.style.maxWidth = '360px';
    notification.innerHTML = `
        <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold shrink-0">
            +
        </div>
        <div class="text-sm font-semibold text-gray-800">
            ${message}
        </div>
    `;
    container.appendChild(notification);
    setTimeout(() => {
        notification.style.opacity = '0';
        notification.style.transition = 'opacity 0.5s ease';
        setTimeout(() => notification.remove(), 500);
    }, 5000);
}

