<x-app-layout>
    <div class="bg-gray-50 min-h-screen pb-12">
        <div class="bg-white border-b border-gray-200 mb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="max-w-xl">
                        <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">
                            Tableau de bord
                        </h2>
                        <p class="mt-2 text-gray-600">Recherchez des opportunités ou connectez-vous avec d'autres talents.</p>
                    </div>

                    @role('recruteur')
                    <div x-data="{ open: false }" class="flex-shrink-0">
                        <button @click="open = !open" 
                            class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition shadow-md hover:shadow-lg">
                            <span x-show="!open" class="flex items-center"><svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg> Publier une offre</span>
                            <span x-show="open">Annuler</span>
                        </button>
                        
                        <div x-show="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 p-4" x-cloak>
                            <div @click.away="open = false" class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto p-8">
                                <livewire:post-job />
                            </div>
                        </div>
                    </div>
                    @endrole
                </div>

                <div class="mt-8">
                    @livewire('job-search')
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-12 gap-8">
                
                <aside class="col-span-12 lg:col-span-3 space-y-6">
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 text-center">
                        <div class="relative mb-4">
                            @if(auth()->user()->profile?->photo)
                                <img src="{{ asset('storage/'.auth()->user()->profile->photo) }}" class="w-20 h-20 rounded-full mx-auto border-4 border-indigo-50 object-cover">
                            @else
                                <div class="w-20 h-20 rounded-full mx-auto bg-indigo-100 flex items-center justify-center font-bold text-indigo-600 text-2xl uppercase">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                            <span class="absolute bottom-0 right-1/2 translate-x-10 w-5 h-5 bg-green-400 border-2 border-white rounded-full"></span>
                        </div>
                        <h3 class="font-bold text-gray-900">{{ auth()->user()->name }}</h3>
                        <p class="text-xs font-bold text-indigo-500 uppercase tracking-widest mt-1">{{ auth()->user()->role }}</p>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm">
                        <h3 class="text-sm font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                            Filtres
                        </h3>
                        <form action="{{ route('dashboard') }}" method="GET" class="space-y-3">
                            @foreach(['Tous' => '', 'Chercheurs' => 'chercheur', 'Recruteurs' => 'recruteur'] as $label => $val)
                                <label class="flex items-center p-2 rounded-lg hover:bg-gray-50 cursor-pointer transition">
                                    <input type="radio" name="role" value="{{ $val }}" 
                                        class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500" 
                                        onchange="this.form.submit()" {{ request('role') == $val ? 'checked' : '' }}>
                                    <span class="ml-3 text-sm font-medium text-gray-700">{{ $label }}</span>
                                </label>
                            @endforeach
                        </form>
                    </div>
                </aside>

                <main class="col-span-12 lg:col-span-9">
                    <div class="mb-6 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-gray-900">Communauté Talentia</h3>
                        <span class="text-sm text-gray-500 bg-white px-3 py-1 rounded-full border border-gray-200">
                            <strong>{{ $users->count() }}</strong> membres
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                        @forelse($users as $u)
                            <div class="bg-white rounded-2xl border border-gray-200 p-5 hover:border-indigo-300 transition-all group shadow-sm">
                                <div class="flex items-start justify-between mb-4">
                                    @if($u->profile?->photo)
                                        <img src="{{ asset('storage/'.$u->profile->photo) }}" class="w-14 h-14 rounded-xl object-cover">
                                    @else
                                        <div class="w-14 h-14 bg-indigo-50 text-indigo-600 rounded-xl flex items-center justify-center text-xl font-bold">
                                            {{ substr($u->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <span class="px-2 py-1 rounded-md text-[10px] font-black uppercase tracking-tighter {{ $u->role === 'recruteur' ? 'bg-emerald-100 text-emerald-700' : 'bg-sky-100 text-sky-700' }}">
                                        {{ $u->role }}
                                    </span>
                                </div>

                                <h4 class="font-bold text-gray-900 group-hover:text-indigo-600 transition">{{ $u->name }}</h4>
                                <p class="text-xs font-bold text-indigo-500 mb-3">{{ $u->profile?->specialty ?? 'Talent Talentia' }}</p>
                                
                                <p class="text-xs text-gray-500 line-clamp-2 mb-5 h-8">
                                    {{ $u->profile?->bio ?? 'Pas encore de bio...' }}
                                </p>

                                <div class="flex gap-2 mt-auto">
                                    <a href="{{ route('profile.show', $u->id) }}" class="flex-1 text-center py-2 text-xs font-bold text-gray-700 bg-gray-50 rounded-lg hover:bg-gray-100 transition border border-gray-200">
                                        Profil
                                    </a>
                                    <form action="{{ route('friendship.send', $u->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button class="w-full py-2 text-xs font-bold text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 transition shadow-sm">
                                            Suivre
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full py-20 text-center bg-white rounded-2xl border-2 border-dashed border-gray-200">
                                <p class="text-gray-400">Aucun membre ne correspond à votre recherche.</p>
                            </div>
                        @endforelse
                    </div>
                </main>
            </div>
        </div>
    </div>
</x-app-layout>