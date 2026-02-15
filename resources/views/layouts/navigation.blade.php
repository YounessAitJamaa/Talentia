<nav class="bg-white shadow-sm sticky top-0 left-0 right-0 z-50 border-b border-gray-200"
    x-data="{ open: false, profileOpen: false }">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex h-16 items-center justify-between">
            <div class="flex items-center">
                <a class="flex-shrink-0 flex items-center gap-2" href="{{ route('dashboard') }}">
                    <span class="text-blue-600 text-2xl font-bold tracking-tight">connect</span>
                </a>
            </div>

            <!-- DESKTOP NAVIGATION -->
            <div class="hidden md:flex items-center justify-center flex-1 max-w-2xl mx-8">
                <div class="flex items-center gap-1 self-center w-full justify-center">
                    <a class="px-4 mt-1 gap-1 rounded-xl transition-all duration-200 ease-in-out flex flex-col items-center justify-center relative group border-b-2 {{ request()->routeIs('dashboard') ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-gray-500 hover:text-blue-600' }}"
                        href="{{ route('dashboard') }}">
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="h-6 w-6 transition-transform group-hover:scale-110">
                                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                <polyline points="9 22 9 12 15 12 15 22"></polyline>
                            </svg>
                        </div>
                        <span class="text-[10px] text-center uppercase tracking-wider">Home</span>
                    </a>

                    @role('recruteur')
                    <a class="px-4 mt-1 gap-1 rounded-xl transition-all duration-200 ease-in-out flex flex-col items-center justify-center relative group border-b-2 {{ request()->routeIs('recruiter.dashboard') ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-gray-500 hover:text-blue-600' }}"
                        href="{{ route('recruiter.dashboard') }}">
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="h-6 w-6 transition-transform group-hover:scale-110">
                                <rect width="20" height="14" x="2" y="7" rx="2" ry="2" />
                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                            </svg>
                        </div>
                        <span class="text-[10px] text-center uppercase tracking-wider">My Offers</span>
                    </a>
                    @endrole

                    <a class="px-4 mt-1 gap-1 rounded-xl transition-all duration-200 ease-in-out flex flex-col items-center justify-center relative group border-b-2 {{ request()->routeIs('community.*') ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-gray-500 hover:text-blue-600' }}"
                        href="{{ route('community.index') }}">
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="h-6 w-6 transition-transform group-hover:scale-110">
                                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <span class="text-[10px] text-center uppercase tracking-wider">Community</span>
                    </a>

                    <a class="px-4 mt-1 gap-1 rounded-xl transition-all duration-200 ease-in-out flex flex-col items-center justify-center relative group border-b-2 {{ request()->routeIs('messages.*') ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-gray-500 hover:text-blue-600' }}"
                        href="{{ route('messages.show') }}">
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="h-6 w-6 transition-transform group-hover:scale-110">
                                <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"></path>
                            </svg>
                        </div>
                        <span class="text-[10px] text-center uppercase tracking-wider">Messages</span>
                    </a>

                    <a class="px-4 mt-1 gap-1 rounded-xl transition-all duration-200 ease-in-out flex flex-col items-center justify-center relative group border-b-2 {{ request()->routeIs('friendships.*') ? 'border-blue-600 text-blue-600 font-semibold' : 'border-transparent text-gray-500 hover:text-blue-600' }}"
                        href="{{ route('friendships.index') }}">
                        <div class="relative">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="h-6 w-6 transition-transform group-hover:scale-110">
                                <path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"></path>
                                <path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"></path>
                            </svg>
                            <livewire:navigation.pending-requests-count />
                        </div>
                        <span class="text-[10px] text-center uppercase tracking-wider">Invitations</span>
                    </a>
                </div>
            </div>

            <!-- RIGHT ACTIONS -->
            <div class="flex items-center gap-4">
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('profile.edit') }}"
                        class="p-2 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition-all">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z">
                            </path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </a>
                </div>

                <!-- PROFILE DROPDOWN -->
                <div class="relative" @click.away="profileOpen = false">
                    <button @click="profileOpen = !profileOpen"
                        class="flex items-center gap-2 p-1 rounded-full hover:bg-gray-100 transition focus:outline-none">
                        @if(auth()->user()->profile?->photo)
                            <img src="{{ asset('storage/' . auth()->user()->profile->photo) }}"
                                class="h-9 w-9 rounded-full object-cover ring-2 ring-transparent group-hover:ring-blue-500 transition-all">
                        @else
                            <div
                                class="h-9 w-9 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-sm">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        @endif
                        <div class="hidden lg:block text-left mr-1">
                            <div class="text-xs font-semibold text-gray-900 leading-tight">{{ auth()->user()->name }}
                            </div>
                            <div class="text-[10px] text-gray-500 font-medium" data-status-text="{{ auth()->id() }}">En
                                ligne</div>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="text-gray-400 transition-transform" :class="{ 'rotate-180': profileOpen }">
                            <path d="m6 9 6 6 6-6"></path>
                        </svg>
                    </button>

                    <div x-show="profileOpen" x-transition:enter="transition ease-out duration-100"
                        x-transition:enter-start="transform opacity-0 scale-95"
                        x-transition:enter-end="transform opacity-100 scale-100"
                        x-transition:leave="transition ease-in duration-75"
                        x-transition:leave-start="transform opacity-100 scale-100"
                        x-transition:leave-end="transform opacity-0 scale-95"
                        class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-gray-100 py-2 z-[60]"
                        style="display: none;">
                        <a href="{{ route('profile.show', auth()->id()) }}"
                            class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="mr-3 text-gray-400">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                            Mon Profil
                        </a>
                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="mr-3 text-gray-400">
                                <path
                                    d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z">
                                </path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                            Paramètres
                        </a>
                        <div class="h-px bg-gray-100 my-2"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full flex items-center px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors text-left">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="mr-3">
                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                                    <polyline points="16 17 21 12 16 7"></polyline>
                                    <line x1="21" x2="9" y1="12" y2="12"></line>
                                </svg>
                                Décconnexion
                            </button>
                        </form>
                    </div>
                </div>

                <!-- MOBILE MENU BUTTON -->
                <button @click="open = !open"
                    class="md:hidden p-2 text-gray-500 hover:text-blue-600 hover:bg-gray-100 rounded-lg transition-all focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        x-show="!open">
                        <line x1="4" x2="20" y1="12" y2="12"></line>
                        <line x1="4" x2="20" y1="6" y2="6"></line>
                        <line x1="4" x2="20" y1="18" y2="18"></line>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        x-show="open" style="display: none;">
                        <line x1="18" x2="6" y1="6" y2="18"></line>
                        <line x1="6" x2="18" y1="6" y2="18"></line>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- MOBILE NAVIGATION -->
    <div x-show="open" class="md:hidden border-t border-gray-100 bg-white" style="display: none;">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}"
                class="block px-4 py-3 rounded-xl text-base font-medium {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }}">
                Tableau de bord
            </a>
            @role('recruteur')
            <a href="{{ route('recruiter.dashboard') }}"
                class="block px-4 py-3 rounded-xl text-base font-medium {{ request()->routeIs('recruiter.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }}">
                Mes Offres
            </a>
            @endrole
            <a href="{{ route('community.index') }}"
                class="block px-4 py-3 rounded-xl text-base font-medium {{ request()->routeIs('community.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }}">
                Communauté
            </a>
            <a href="{{ route('messages.show') }}"
                class="block px-4 py-3 rounded-xl text-base font-medium {{ request()->routeIs('messages.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }}">
                Messages
            </a>
            <a href="{{ route('friendships.index') }}"
                class="block px-4 py-3 rounded-xl text-base font-medium {{ request()->routeIs('friendships.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }}">
                Invitations
            </a>
        </div>
    </div>
</nav>