<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
            <div class="flex items-center space-x-8">
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <span class="text-2xl font-extrabold text-indigo-600">Connect<span class="text-gray-900">Hub</span></span>
                </a>
            </div>

         <!--    <div class="hidden sm:block flex-1 max-w-xs px-4">
                <form action="{{ route('dashboard') }}" method="GET">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               class="w-full bg-gray-100 border-none rounded-lg py-1.5 pl-3 text-sm focus:ring-2 focus:ring-indigo-500" 
                               placeholder="Rechercher...">
                    </div>
                </form>
            </div> -->

            @php
                $pendingCount = \App\Models\Friendship::where('friend_id', auth()->id())
                                ->where('status', 'pending')
                                ->count();
            @endphp

            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex items-center">
                <div class="hidden space-x-6 sm:-my-px sm:ml-10 sm:flex items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Réseau') }}
                    </x-nav-link>

                    <x-nav-link :href="route('community.index')" :active="request()->routeIs('community.*')">
                        {{ __('Communauté') }}
                    </x-nav-link>

                    <a href="{{ route('friendships.index') }}"
                    class="relative inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 transition">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>

                        @if($pendingCount > 0)
                            <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-red-600 text-[10px] font-bold text-white">
                                {{ $pendingCount }}
                            </span>
                        @endif
                    </a>
                </div>

            </div>

            <div class="flex items-center space-x-4">
                <div class="text-right hidden md:block">
                    <div class="text-sm font-bold text-gray-900 leading-none">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</div>
                      {{-- test de status -----}}

                            <div class="flex items-center gap-2">
                                <!-- Indicateur de statut -->
                                <span class="inline-block w-3 h-3 rounded-full 
                                    @if(auth()->user()->status == 'online') bg-green-500 
                                    @else bg-gray-500 @endif"></span>

                                <span class="text-sm text-gray-600">
                                    @if(auth()->user()->status == 'online')
                                        En ligne
                                    @else
                                        Hors ligne
                                    @endif
                                </span>
                            </div>
                </div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                            @if(auth()->user()->profile?->photo)
                                <img src="{{ asset('storage/'.auth()->user()->profile->photo) }}" class="h-9 w-9 rounded-full object-cover">
                            @else
                                <div class="h-9 w-9 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Mon Profil</x-dropdown-link>
                        <hr>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                                Déconnexion
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

        </div>
    </div>
</nav>