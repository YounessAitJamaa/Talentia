import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

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
                <div class="max-w-[80%] md:max-w-[60%]">
                    <div class="rounded-2xl rounded-tr-none bg-[#2563EB] p-4 shadow-sm">
                        <p class="text-sm leading-relaxed text-white">${message.content}</p>
                    </div>
                    <div class="mt-2 flex justify-end">
                        <span class="text-[11px] font-medium text-gray-400">${time}</span>
                    </div>
                </div>
            </div>
        `;
    } else {
        const photo = message.sender && message.sender.profile && message.sender.profile.photo
            ? `/storage/${message.sender.profile.photo}`
            : null;
        const initial = message.sender ? message.sender.name.charAt(0).toUpperCase() : '?';

        html = `
            <div class="flex justify-start gap-3 animate-fade-in-up">
                <div class="h-9 w-9 flex-shrink-0 rounded-full bg-gray-100 overflow-hidden mt-1">
                    ${photo
                ? `<img src="${photo}" class="h-full w-full object-cover" />`
                : `<div class="h-full w-full flex items-center justify-center bg-gray-200 text-gray-600 font-bold text-[10px]">${initial}</div>`
            }
                </div>
                <div class="max-w-[80%] md:max-w-[60%]">
                    <div class="rounded-2xl rounded-tl-none bg-white border border-gray-100 p-4 shadow-sm">
                        <p class="text-sm leading-relaxed text-gray-700">${message.content}</p>
                    </div>
                    <div class="mt-2 flex items-center gap-2">
                        <span class="text-[11px] font-semibold text-gray-800">${message.sender ? message.sender.name : 'Unknown'}</span>
                        <span class="text-[11px] font-medium text-gray-400">${time}</span>
                    </div>
                </div>
            </div>
        `;
    }

    chatMessages.insertAdjacentHTML('beforeend', html);
    chatMessages.scrollTop = chatMessages.scrollHeight;
};


function applyStatus(userId, status) {
    document.querySelectorAll(`[data-status-dot="${userId}"]`).forEach(el => {
        el.classList.toggle('bg-green-500', status === 'online');
        el.classList.toggle('bg-gray-500', status !== 'online');
    });

    document.querySelectorAll(`[data-status-text="${userId}"]`).forEach(el => {
        el.textContent = status === 'online' ? 'En ligne' : 'Hors ligne';
        el.classList.toggle('text-green-600', status === 'online');
        el.classList.toggle('text-gray-500', status !== 'online');
    });
}


window.Echo.channel('user-status')
    .listen('.user.status.updated', (e) => {
        const userId = String(e.userId);
        const isOnline = e.status === 'online';

        // dots
        document.querySelectorAll(`[data-role="status-dot"][data-user-id="${userId}"]`)
            .forEach(el => {
                el.classList.toggle('bg-green-500', isOnline);
                el.classList.toggle('bg-gray-400', !isOnline);
            });

        // texts
        document.querySelectorAll(`[data-role="status-text"][data-user-id="${userId}"]`)
            .forEach(el => {
                el.textContent = isOnline ? 'Online' : 'Offline';
                el.classList.toggle('text-green-500', isOnline);
                el.classList.toggle('text-gray-500', !isOnline);
            });
    });

