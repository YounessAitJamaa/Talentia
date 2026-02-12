<x-app-layout>
    <div class="mx-auto max-w-6xl mt-10 p-4 mb-10  dark:bg-white text-[#1b1b18] shadow-sm rounded-3xl" x-data="{ isMobile: false }">
        <!-- Breadcrumb Start -->
        <div x-data="{ pageName: 'Chat' }">
            <div class="flex flex-wrap items-center justify-between gap-3 pb-6">
                <h2 class="text-xl font-semibold text-gray-800 dark:text-[#1b1b18]" x-text="pageName"></h2>
                <nav>
                    <ol class="flex items-center gap-1.5">
                        <li>
                            <a class="inline-flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400" href="{{ route('dashboard') }}">
                                Home
                                <svg class="stroke-current" width="17" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.0765 12.667L10.2432 8.50033L6.0765 4.33366" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </a>
                        </li>
                        <li class="text-sm text-gray-800 dark:text-[#1b1b18]" x-text="pageName"></li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Breadcrumb End -->

        <div class="h-[calc(100vh-220px)] overflow-hidden">
            <div class="flex h-full flex-col gap-6 xl:flex-row xl:gap-5 relative">
                
                <!-- Mobile Overlay -->
                <div x-show="isMobile" 
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-40 bg-gray-900/50 xl:hidden" 
                     @click="isMobile = false"></div>

                <!-- Chat Sidebar Start -->
                <div :class="isMobile ? 'translate-x-0' : '-translate-x-full'" 
                     class="fixed inset-y-0 left-0 z-50 flex w-[290px] flex-col overflow-hidden border-r border-gray-200 bg-transparent transition-transform duration-300 xl:static xl:w-1/4 xl:translate-x-0 xl:rounded-2xl xl:border dark:border-gray-200 dark:bg-transparent no-scrollbar">
                    
                    <!-- Sidebar Header - Search -->
                    <div class="sticky top-0 z-10 bg-transparent px-4 pt-4 pb-4 sm:px-5 sm:pt-5 xl:pb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-semibold text-gray-800 dark:text-[#1b1b18]">Messages</h3>
                            <button @click="isMobile = false" class="xl:hidden text-gray-400 hover:text-gray-600">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 18L18 6M6 6L18 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </button>
                        </div>
                        <div class="relative w-full">
                            <span class="absolute top-1/2 left-4 -translate-y-1/2">
                                <svg class="fill-gray-500" width="18" height="18" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M3.04199 9.37381C3.04199 5.87712 5.87735 3.04218 9.37533 3.04218C12.8733 3.04218 15.7087 5.87712 15.7087 9.37381C15.7087 12.8705 12.8733 15.7055 9.37533 15.7055C5.87735 15.7055 3.04199 12.8705 3.04199 9.37381ZM9.37533 1.54218C5.04926 1.54218 1.54199 5.04835 1.54199 9.37381C1.54199 13.6993 5.04926 17.2055 9.37533 17.2055C11.2676 17.2055 13.0032 16.5346 14.3572 15.4178L17.1773 18.2381C17.4702 18.5311 17.945 18.5311 18.2379 18.2382C18.5308 17.9453 18.5309 17.4704 18.238 17.1775L15.4182 14.3575C16.5367 13.0035 17.2087 11.2671 17.2087 9.37381C17.2087 5.04835 13.7014 1.54218 9.37533 1.54218Z" fill="currentColor" />
                                </svg>
                            </span>
                            <input type="text" placeholder="Search..." class="h-10 w-full rounded-lg border border-gray-200 bg-transparent py-2.5 pr-3.5 pl-11 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 focus:outline-none" />
                        </div>
                    </div>

                    <!-- Chat List -->
                    <div class="flex flex-col overflow-y-auto custom-scrollbar flex-1">
                        <!-- Individuals Section -->
                        <div class="px-4 py-3">
                            <h4 class="mb-3 text-xs font-semibold uppercase tracking-wider text-gray-400">Individuals</h4>
                            <div class="space-y-1">
                                @foreach($conversations as $convUser)
                                    <a href="{{ route('messages.show', $convUser->id) }}" class="flex items-center gap-3 rounded-lg p-3 transition-colors hover:bg-gray-50 {{ optional($receiver)->id == $convUser->id ? 'bg-blue-50' : '' }}">
                                        <div class="relative h-11 w-11 flex-shrink-0">
                                            @if($convUser->profile?->photo)
                                                <img src="{{ asset('storage/' . $convUser->profile->photo) }}" class="h-full w-full rounded-full object-cover border border-gray-100" />
                                            @else
                                                <div class="h-full w-full flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold text-sm">
                                                    {{ strtoupper(substr($convUser->name, 0, 1)) }}
                                                </div>
                                            @endif
                                            <!--<span class="absolute bottom-0 right-0 block h-3 w-3 rounded-full border-2 border-white bg-green-500"></span>-->
                                            <span data-role="status-dot" data-user-id="{{ $convUser->id }}" class="absolute bottom-0 right-0 block h-3 w-3 rounded-full border-2 border-white
                                                {{ $convUser->status === 'online' ? 'bg-green-500' : 'bg-gray-400' }}">
                                            </span>

                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <div class="flex items-center justify-between">
                                                <h5 class="text-sm font-semibold text-gray-800 truncate">{{ $convUser->name }}</h5>
                                            </div>
                                            <p class="text-xs text-gray-500 truncate">{{ $convUser->profile?->specialty ?? 'Talent' }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Chat Sidebar End -->

                @if($receiver)
                    <!-- Chat Window Start -->
                    <div class="flex h-full flex-col overflow-hidden rounded-2xl border border-gray-200 bg-white dark:border-gray-200 dark:bg-white xl:w-3/4 flex-1">
                        <!-- Partner Header -->
                        <div class="sticky top-0 z-10 flex items-center justify-between border-b border-gray-200 bg-white px-5 py-4 xl:px-6">
                            <div class="flex items-center gap-3">
                                <button @click="isMobile = true" class="xl:hidden p-2 -ml-2 text-gray-500 hover:text-gray-700">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4 6H20M4 12H12M4 18H20" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                                <div class="relative h-11 w-11 flex-shrink-0">
                                    @if($receiver->profile?->photo)
                                        <img src="{{ asset('storage/' . $receiver->profile->photo) }}" class="h-full w-full rounded-full object-cover border border-gray-100" />
                                    @else
                                        <div class="h-full w-full flex items-center justify-center rounded-full bg-blue-100 text-blue-600 font-bold text-sm">
                                            {{ strtoupper(substr($receiver->name, 0, 1)) }}
                                        </div>
                                    @endif

                                    <span data-role="status-dot" data-user-id="{{ $receiver->id }}" class="absolute bottom-0 right-0 block h-3 w-3 rounded-full border-2 border-white bg-green-500
                                        {{ $receiver->status === 'online' ? 'bg-green-500' : 'bg-gray-400' }}">
                                        </span>
                                        <span data-role="status-text" data-user-id="{{ $receiver->id }}"
                                            class="text-xs font-semibold flex items-center gap-1
                                            {{ $receiver->status === 'online' ? 'text-green-600' : 'text-gray-500' }}">
                                            {{ $receiver->status === 'online' ? 'En ligne' : 'Hors ligne' }}
                                        </span>
                                </div>

                                <div class="min-w-0">
                                    <h5 class="text-sm font-semibold text-gray-800 truncate">{{ $receiver->name }}</h5>
                                   
                                </div>
                            </div>
                        </div>

                        <!-- Message Body -->
                        <div id="chat-messages" data-chat-partner-id="{{ $receiver->id }}" class="flex-1 space-y-6 overflow-y-auto p-5 xl:p-6 no-scrollbar bg-gray-50/30">
                            @forelse($messages as $message)
                                @if($message->sender_id == auth()->id())
                                    <!-- Sent Message -->
                                    <div class="flex justify-end">
                                        <div class="max-w-[80%] md:max-w-[60%]">
                                            <div class="rounded-2xl rounded-tr-none bg-[#2563EB] p-4 shadow-sm">
                                                <p class="text-sm leading-relaxed text-white">{{ $message->content }}</p>
                                            </div>
                                            <div class="mt-2 flex justify-end">
                                                <span class="text-[11px] font-medium text-gray-400">{{ $message->created_at->format('H:i A') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <!-- Received Message -->
                                    <div class="flex justify-start gap-3">
                                        <div class="h-9 w-9 flex-shrink-0 rounded-full bg-gray-100 overflow-hidden mt-1">
                                            @if($message->sender->profile?->photo)
                                                <img src="{{ asset('storage/' . $message->sender->profile->photo) }}" class="h-full w-full object-cover" />
                                            @else
                                                <div class="h-full w-full flex items-center justify-center bg-gray-200 text-gray-600 font-bold text-[10px]">
                                                    {{ strtoupper(substr($message->sender->name, 0, 1)) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="max-w-[80%] md:max-w-[60%]">
                                            <div class="rounded-2xl rounded-tl-none bg-white border border-gray-100 p-4 shadow-sm">
                                                <p class="text-sm leading-relaxed text-gray-700">{{ $message->content }}</p>
                                            </div>
                                            <div class="mt-2 flex items-center gap-2">
                                                <span class="text-[11px] font-semibold text-gray-800">{{ $message->sender->name }}</span>
                                                <span class="text-[11px] font-medium text-gray-400">{{ $message->created_at->format('H:i A') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <div class="flex h-full items-center justify-center text-gray-400 italic">
                                    Start a conversation with {{ $receiver->name }}
                                </div>
                            @endforelse
                        </div>

                        <!-- Message Input -->
                        <div class="border-t border-gray-200 bg-transparent p-4 xl:p-6">
                            <form action="{{ route('messages.send') }}" method="POST" class="flex items-center gap-3">
                                @csrf
                                <input type="hidden" name="receiver_id" value="{{ $receiver->id }}">
                                <div class="relative flex-1">
                                    <input type="text" name="content" autocomplete="off" placeholder="Write your message..." 
                                           class="h-12 w-full rounded-xl border border-gray-200 bg-transparent px-4 text-sm text-gray-800 placeholder:text-gray-400 focus:border-blue-500 focus:ring-1 focus:ring-blue-500/20 focus:outline-none transition-all" required />
                                </div>
                                <button type="submit" class="flex h-12 w-12 items-center justify-center rounded-xl bg-[#2563EB] text-white hover:bg-[#1d4ed8] shadow-lg shadow-blue-500/20 transition-all active:scale-90">
                                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M17.5 2.5L2.5 9.16667L8.33333 11.6667L10.8333 17.5L17.5 2.5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    <!-- Chat Window End -->
                @else
                    <div class="flex h-full flex-col items-center justify-center bg-white dark:bg-white xl:w-3/4 flex-1 rounded-2xl border border-gray-200 text-gray-400">
                         <div class="p-8 text-center">
                            <div class="mb-4 inline-flex h-20 w-20 items-center justify-center rounded-full bg-blue-50 text-blue-500">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M8 12H8.01M12 12H12.01M16 12H16.01M21 12C21 16.9706 16.9706 21 12 21C10.4578 21 9.01182 20.6224 7.72522 19.9542L3 21L4.04578 16.2748C3.37758 14.9882 3 13.5422 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <h3 class="mb-2 text-lg font-semibold text-gray-800">No conversation selected</h3>
                            <p class="max-w-xs text-sm text-gray-500">Select a talent from the sidebar to start messaging.</p>
                         </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e5e7eb;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #d1d5db;
        }
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</x-app-layout>