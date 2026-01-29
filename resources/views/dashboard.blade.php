<x-app-layout>
    <div class="bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-12 gap-6">
                
                <div class="hidden md:block md:col-span-3 space-y-4">
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm">
                        <div class="h-16 bg-indigo-600"></div>
                        <div class="px-4 pb-4">
                            <div class="relative -mt-8 flex justify-center">
                                @if(auth()->user()->profile?->photo)
                                    <img src="{{ asset('storage/'.auth()->user()->profile->photo) }}" class="w-16 h-16 rounded-full border-4 border-white object-cover">
                                @else
                                    <div class="w-16 h-16 rounded-full border-4 border-white bg-indigo-100 flex items-center justify-center font-bold text-indigo-600 uppercase text-xl">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div class="text-center mt-2">
                                <h3 class="font-bold text-gray-900">{{ auth()->user()->name }}</h3>
                                <p class="text-xs text-gray-500 uppercase">{{ auth()->user()->role }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-sm">
                        <h3 class="text-sm font-semibold text-gray-900 mb-4 border-b pb-2">Filtrer par catégorie</h3>
                        <form action="{{ route('dashboard') }}" method="GET" id="filterForm">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <div class="space-y-3">
                                @foreach(['tous' => '', 'chercheurs' => 'chercheur', 'recruteurs' => 'recruteur'] as $label => $val)
                                    <label class="flex items-center group cursor-pointer">
                                        <input type="radio" name="role" value="{{ $val }}" 
                                            class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" 
                                            onchange="this.form.submit()" {{ request('role') == $val ? 'checked' : '' }}>
                                        <span class="ml-3 text-sm text-gray-600 group-hover:text-indigo-600 transition">{{ ucfirst($label) }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-span-12 md:col-span-9 space-y-6">
                    
                    <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm">
                        <form action="{{ route('dashboard') }}" method="GET" class="flex gap-2">
                            <div class="relative flex-grow">
                                <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                                </span>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg bg-gray-50 focus:bg-white focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" 
                                    placeholder="Rechercher un talent ou un recruteur...">
                            </div>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg font-medium hover:bg-indigo-700 transition">Rechercher</button>
                        </form>
                    </div>

                    <div class="flex items-center justify-between">
                        <p class="text-sm text-gray-500 italic">Affichage de <strong>{{ $users->count() }}</strong> membres trouvés</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @forelse($users as $u)
                            <div class="bg-white rounded-xl border border-gray-200 p-6 hover:shadow-lg transition-shadow duration-300 relative group text-center">
                                <span class="absolute top-3 right-3 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider {{ $u->role === 'recruteur' ? 'bg-green-100 text-green-700' : 'bg-blue-100 text-blue-700' }}">
                                    {{ $u->role }}
                                </span>

                                @if($u->profile?->photo)
                                    <img src="{{ asset('storage/'.$u->profile->photo) }}" class="w-20 h-20 rounded-full mx-auto object-cover border-2 border-indigo-50 transition-transform group-hover:scale-105">
                                @else
                                    <div class="w-20 h-20 bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-full mx-auto flex items-center justify-center text-2xl font-bold shadow-md">
                                        {{ substr($u->name, 0, 1) }}
                                    </div>
                                @endif

                                <h4 class="mt-4 font-bold text-gray-900 truncate">{{ $u->name }}</h4>
                                <p class="text-sm font-medium text-indigo-600 truncate mb-2">{{ $u->profile?->specialty ?? 'Sans spécialité' }}</p>
                                
                                <p class="text-xs text-gray-500 line-clamp-2 min-h-[32px] mb-4">
                                    {{ $u->profile?->bio ?? 'Aucune biographie disponible pour le moment.' }}
                                </p>

                                <a href="{{ route('profile.show', $u->id) }}" class="inline-flex items-center justify-center w-full px-4 py-2 border-2 border-indigo-600 text-indigo-600 font-semibold rounded-lg hover:bg-indigo-600 hover:text-white transition duration-200 text-sm">
                                    Voir le profil
                                </a>
                            </div>
                        @empty
                            <div class="col-span-full py-12 text-center bg-white rounded-xl border border-dashed border-gray-300">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun résultat</h3>
                                <p class="mt-1 text-sm text-gray-500">Essayez de modifier vos filtres ou votre recherche.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>