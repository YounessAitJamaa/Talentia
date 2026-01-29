<nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
            <div class="flex items-center space-x-8">
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    <span class="text-2xl font-extrabold text-indigo-600">Connect<span class="text-gray-900">Hub</span></span>
                </a>
                <div class="hidden md:flex space-x-4">
                    <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-700 hover:text-indigo-600 {{ request()->routeIs('dashboard') ? 'border-b-2 border-indigo-600' : '' }}">
                        Réseau
                    </a>
                </div>
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

            <div class="flex items-center space-x-4">
                <div class="text-right hidden md:block">
                    <div class="text-sm font-bold text-gray-900 leading-none">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</div>
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