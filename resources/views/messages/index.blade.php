<x-app-layout>
    <div class="pt-6 pb-8">
        <div class="max-w-7xl mx-auto px-4">
            {{-- MAIN MESSAGING INTERFACE: Full width now that sidebar is removed --}}
            <main class="py-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden h-[calc(100vh-8rem)]">
                    <div class="flex h-full">

                        {{-- CONVERSATION LIST (SIDEBAR) --}}
                        <div class="{{ $receiver ? 'hidden sm:flex' : 'flex' }} w-full sm:w-80 border-r border-gray-200 flex-col"
                            x-data="{ search: '' }">
                            <div class="p-4 border-b border-gray-200">
                                <div class="relative">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="lucide lucide-search absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-gray-400">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <path d="m21 21-4.3-4.3"></path>
                                    </svg>
                                    <input type="text" x-model="search" placeholder="Search messages..."
                                        class="w-full pl-9 pr-4 py-2 bg-gray-100 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-500" />
                                </div>
                            </div>
                            <div class="flex-1 overflow-y-auto no-scrollbar">
                                @foreach($conversations as $convUser)
                                    <a href="{{ route('messages.show', $convUser->id) }}"
                                        class="w-full p-4 flex items-start gap-3 hover:bg-gray-50 transition-colors {{ optional($receiver)->id == $convUser->id ? 'bg-blue-50' : '' }}"
                                        x-show="!search || '{{ strtolower($convUser->name) }}'.includes(search.toLowerCase())">
                                        <div class="relative">
                                            @if($convUser->profile?->photo)
                                                <img src="{{ asset('storage/' . $convUser->profile->photo) }}"
                                                    alt="{{ $convUser->name }}" class="w-12 h-12 rounded-full object-cover" />
                                            @else
                                                <div
                                                    class="w-12 h-12 rounded-full flex items-center justify-center bg-blue-100 text-blue-600 font-bold text-sm">
                                                    {{ strtoupper(substr($convUser->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div data-role="status-dot" data-user-id="{{ $convUser->id }}"
                                                class="absolute bottom-0 right-0 w-3 h-3 rounded-full border-2 border-white {{ $convUser->status === 'online' ? 'bg-green-500' : 'bg-gray-400' }}">
                                            </div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex justify-between items-baseline">
                                                <h3 class="font-medium text-gray-900 truncate">{{ $convUser->name }}</h3>
                                            </div>
                                            <p class="text-sm text-gray-500 truncate">
                                                {{ $convUser->profile?->specialty ?? 'Talent' }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        {{-- CHAT PANEL --}}
                        <div class="{{ $receiver ? 'flex' : 'hidden sm:flex' }} flex-1 flex-col">
                            @if($receiver)
                                {{-- HEADER --}}
                                <div class="p-4 border-b border-gray-200 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        {{-- Back Button for Mobile --}}
                                        <a href="{{ route('messages.show') }}"
                                            class="sm:hidden p-2 -ml-2 text-gray-500 hover:text-blue-600 transition-colors">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                                                <path d="m15 18-6-6 6-6" />
                                            </svg>
                                        </a>

                                        <div class="relative">
                                            @if($receiver->profile?->photo)
                                                <img src="{{ asset('storage/' . $receiver->profile->photo) }}"
                                                    alt="{{ $receiver->name }}" class="w-10 h-10 rounded-full object-cover" />
                                            @else
                                                <div
                                                    class="w-10 h-10 rounded-full flex items-center justify-center bg-blue-100 text-blue-600 font-bold text-sm">
                                                    {{ strtoupper(substr($receiver->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <div data-role="status-dot" data-user-id="{{ $receiver->id }}"
                                                class="absolute bottom-0 right-0 w-2.5 h-2.5 rounded-full border-2 border-white {{ $receiver->status === 'online' ? 'bg-green-500' : 'bg-gray-400' }}">
                                            </div>
                                        </div>
                                        <div>
                                            <h2 class="font-medium text-gray-900">{{ $receiver->name }}</h2>
                                            <p data-role="status-text" data-user-id="{{ $receiver->id }}"
                                                class="text-xs {{ $receiver->status === 'online' ? 'text-green-600' : 'text-gray-500' }}">
                                                {{ $receiver->status === 'online' ? 'Online' : 'Offline' }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-1 sm:gap-3 text-gray-400">
                                        <button title="Audio Call"
                                            class="p-2 hover:text-blue-600 hover:bg-blue-50 rounded-full transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                                <path
                                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z">
                                                </path>
                                            </svg>
                                        </button>
                                        <button title="Video Call"
                                            class="p-2 hover:text-blue-600 hover:bg-blue-50 rounded-full transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                                <path d="m22 8-6 4 6 4V8Z"></path>
                                                <rect width="14" height="12" x="2" y="6" rx="2" ry="2"></rect>
                                            </svg>
                                        </button>
                                        <button title="Information"
                                            class="p-2 hover:text-blue-600 hover:bg-blue-50 rounded-full transition-all">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                                                <circle cx="12" cy="12" r="10"></circle>
                                                <path d="M12 16v-4"></path>
                                                <path d="M12 8h.01"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                {{-- MESSAGES BODY --}}
                                <div id="chat-messages" data-chat-partner-id="{{ $receiver->id }}"
                                    class="flex-1 overflow-y-auto p-4 space-y-4 no-scrollbar bg-gray-50/30 scroll-smooth">
                                    @forelse($messages as $message)
                                        @if($message->sender_id == auth()->id())
                                            {{-- SENT BY ME --}}
                                            <div class="flex justify-end animate-fade-in-up">
                                                <div class="max-w-[70%] rounded-2xl px-4 py-2 bg-blue-600 text-white shadow-sm">
                                                    <p class="text-sm">{{ $message->content }}</p>
                                                    <p class="text-[10px] mt-1 text-blue-100 text-right">
                                                        {{ $message->created_at->format('H:i A') }}</p>
                                                </div>
                                            </div>
                                        @else
                                            {{-- RECEIVED --}}
                                            <div class="flex justify-start animate-fade-in-up">
                                                <div
                                                    class="max-w-[70%] rounded-2xl px-4 py-2 bg-white border border-gray-100 text-gray-900 shadow-sm">
                                                    <p class="text-sm font-semibold text-gray-800 mb-0.5">
                                                        {{ $message->sender->name }}</p>
                                                    <p class="text-sm">{{ $message->content }}</p>
                                                    <p class="text-[10px] mt-1 text-gray-500">
                                                        {{ $message->created_at->format('H:i A') }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    @empty
                                        <div class="flex h-full items-center justify-center text-gray-400 italic">
                                            Start a conversation with {{ $receiver->name }}
                                        </div>
                                    @endforelse
                                </div>

                                {{-- INPUT AREA --}}
                                <div class="p-4 bg-white border-t border-gray-100">
                                    <form action="{{ route('messages.send') }}" method="POST"
                                        class="flex items-end gap-3 max-w-5xl mx-auto">
                                        @csrf
                                        <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">

                                        <button type="button" title="Attach File"
                                            class="mb-1 p-2.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-full transition-all duration-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path
                                                    d="m21.44 11.05-9.19 9.19a6 6 0 0 1-8.49-8.49l8.57-8.57A4 4 0 1 1 18 8.84l-8.59 8.57a2 2 0 0 1-2.83-2.83l8.49-8.48">
                                                </path>
                                            </svg>
                                        </button>

                                        <div
                                            class="flex-1 relative flex items-center bg-gray-50 rounded-2xl border border-gray-200 focus-within:border-blue-400 focus-within:ring-4 focus-within:ring-blue-50 transition-all duration-200">
                                            <textarea id="message-input" name="content" rows="1" required
                                                placeholder="Type a message..."
                                                class="w-full px-4 py-3 bg-transparent border-none focus:ring-0 resize-none text-gray-700 leading-relaxed max-h-32 no-scrollbar"
                                                oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"></textarea>

                                            <div class="flex items-center gap-1 pr-2">
                                                <button type="button" title="Emoji"
                                                    class="p-1.5 text-gray-400 hover:text-yellow-500 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <circle cx="12" cy="12" r="10"></circle>
                                                        <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                                                        <line x1="9" x2="9.01" y1="9" y2="9"></line>
                                                        <line x1="15" x2="15.01" y1="9" y2="9"></line>
                                                    </svg>
                                                </button>
                                                <button type="button" title="Send Image"
                                                    class="p-1.5 text-gray-400 hover:text-blue-500 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <rect width="18" height="18" x="3" y="3" rx="2" ry="2">
                                                        </rect>
                                                        <circle cx="9" cy="9" r="2"></circle>
                                                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"></path>
                                                    </svg>
                                                </button>
                                                <button type="button" title="Voice Message"
                                                    class="p-1.5 text-gray-400 hover:text-red-500 transition-colors">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round">
                                                        <path d="M12 2a3 3 0 0 0-3 3v7a3 3 0 0 0 6 0V5a3 3 0 0 0-3-3Z">
                                                        </path>
                                                        <path d="M19 10v2a7 7 0 0 1-14 0v-2"></path>
                                                        <line x1="12" x2="12" y1="19" y2="22"></line>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <button type="submit"
                                            class="mb-1 p-3 rounded-xl bg-blue-600 text-white hover:bg-blue-700 transition-all shadow-lg shadow-blue-200 active:scale-95 flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round">
                                                <path d="m22 2-7 20-4-9-9-4Z"></path>
                                                <path d="M22 2 11 13"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>

                                <script>
                                    document.addEventListener("DOMContentLoaded", function () {
                                        const chatMessages = document.getElementById('chat-messages');

                                        const scrollToBottom = () => {
                                            if (chatMessages) {
                                                chatMessages.scrollTop = chatMessages.scrollHeight;
                                            }
                                        };

                                        scrollToBottom();

                                        const observer = new MutationObserver(scrollToBottom);
                                        if (chatMessages) {
                                            observer.observe(chatMessages, { childList: true });
                                        }

                                        const textarea = document.getElementById('message-input');
                                        if (textarea) {
                                            textarea.addEventListener('keydown', (e) => {
                                                if (e.key === 'Enter' && !e.shiftKey) {
                                                    e.preventDefault();
                                                    if (textarea.value.trim()) {
                                                        textarea.closest('form').submit();
                                                    }
                                                }
                                            });
                                        }
                                    });
                                </script>
                            @else
                                {{-- NO CONVERSATION SELECTED --}}
                                <div class="flex h-full flex-col items-center justify-center bg-gray-50/20 text-gray-400">
                                    <div class="p-8 text-center animate-fade-in-up">
                                        <div
                                            class="mb-6 inline-flex h-24 w-24 items-center justify-center rounded-3xl bg-blue-50 text-blue-500 shadow-inner">
                                            <svg width="40" height="40" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M8 12H8.01M12 12H12.01M16 12H16.01M21 12C21 16.9706 16.9706 21 12 21C10.4578 21 9.01182 20.6224 7.72522 19.9542L3 21L4.04578 16.2748C3.37758 14.9882 3 13.5422 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                        </div>
                                        <h3 class="mb-2 text-xl font-bold text-gray-800">Your Messages</h3>
                                        <p class="max-w-xs text-sm text-gray-500 mx-auto leading-relaxed">Select a talent
                                            from the list to start a professional conversation.</p>
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
        </div>
        </main>
    </div>
    </div>

    <style>
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Premium Scrollbar for message body (if you want it hidden, use no-scrollbar on the div) */
        #chat-messages::-webkit-scrollbar {
            width: 0px;
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Improved shadows and transitions */
        .shadow-premium {
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
        }
    </style>
</x-app-layout>