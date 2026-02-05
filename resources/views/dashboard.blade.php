<x-app-layout>
    <div class="min-h-screen bg-slate-50">
        {{-- TOP HEADER --}}
        <div class="border-b bg-white/80 backdrop-blur">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                    <div>
                        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">
                            Tableau de bord
                        </h2>
                        <p class="mt-2 text-slate-600">
                            Recherchez des opportunités ou connectez-vous avec d'autres talents.
                        </p>
                    </div>

                    @role('recruteur')
                    <div x-data="{ open: false }" class="flex-shrink-0">
                        <button
                            @click="open = !open"
                            class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-xl bg-indigo-600 text-white font-bold shadow-sm hover:bg-indigo-700 transition"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Publier une offre
                        </button>

                        {{-- MODAL --}}
                        <div
                            x-show="open"
                            x-cloak
                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4"
                        >
                            <div
                                @click.away="open = false"
                                class="w-full max-w-2xl rounded-2xl bg-white shadow-2xl overflow-hidden"
                            >
                                <div class="flex items-center justify-between px-6 py-4 border-b">
                                    <h3 class="font-extrabold text-slate-900">Nouvelle offre</h3>
                                    <button @click="open=false" class="text-slate-500 hover:text-slate-900">
                                        ✕
                                    </button>
                                </div>

                                <div class="p-6 max-h-[80vh] overflow-y-auto">
                                    <livewire:post-job />
                                </div>
                            </div>
                        </div>
                    </div>
                    @endrole
                </div>

                {{-- JOB SEARCH --}}
                <div class="mt-6">
                    @livewire('job-search')
                </div>
            </div>
        </div>

        {{-- CONTENT --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-12 gap-8">
                {{-- SIDEBAR --}}
                <aside class="col-span-12 lg:col-span-3">
                    <div class="lg:sticky lg:top-6 space-y-6">
                        {{-- PROFILE CARD --}}
                        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 p-6">
                            <div class="flex items-center gap-4">
                                <div class="relative">
                                    @if(auth()->user()->profile?->photo)
                                        <img
                                            src="{{ asset('storage/'.auth()->user()->profile->photo) }}"
                                            class="w-14 h-14 rounded-2xl object-cover ring-2 ring-indigo-50"
                                        >
                                    @else
                                        <div class="w-14 h-14 rounded-2xl bg-indigo-100 flex items-center justify-center font-extrabold text-indigo-600 text-xl uppercase">
                                            {{ substr(auth()->user()->name, 0, 1) }}
                                        </div>
                                    @endif
                                    <span class="absolute -bottom-1 -right-1 w-4 h-4 rounded-full bg-emerald-400 ring-2 ring-white"></span>
                                </div>

                                <div class="min-w-0">
                                    <p class="font-extrabold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                                    <p class="text-xs font-black uppercase tracking-widest text-indigo-600">
                                        {{ auth()->user()->role }}
                                    </p>
                                </div>
                            </div>

                            <div class="mt-5 grid grid-cols-2 gap-2">
                                <a href="{{ route('profile.show', auth()->id()) }}"
                                   class="text-center text-sm font-bold py-2 rounded-xl bg-slate-100 hover:bg-slate-200 transition">
                                    Mon profil
                                </a>
                                <a href="{{ route('dashboard') }}"
                                   class="text-center text-sm font-bold py-2 rounded-xl bg-white ring-1 ring-slate-200 hover:bg-slate-50 transition">
                                    Actualiser
                                </a>
                            </div>
                        </div>

                        {{-- FILTERS --}}
                        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 p-6">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-extrabold text-slate-900">Filtres</h3>
                                <span class="text-xs text-slate-500">Communauté</span>
                            </div>

                            <form action="{{ route('dashboard') }}" method="GET" class="mt-4 space-y-2">
                                @foreach(['Tous' => '', 'Chercheurs' => 'chercheur', 'Recruteurs' => 'recruteur'] as $label => $val)
                                    <label class="flex items-center gap-3 rounded-xl px-3 py-2 hover:bg-slate-50 cursor-pointer transition">
                                        <input
                                            type="radio"
                                            name="role"
                                            value="{{ $val }}"
                                            class="w-4 h-4 text-indigo-600 border-slate-300 focus:ring-indigo-500"
                                            onchange="this.form.submit()"
                                            {{ request('role') == $val ? 'checked' : '' }}
                                        >
                                        <span class="text-sm font-semibold text-slate-700">{{ $label }}</span>
                                    </label>
                                @endforeach
                            </form>
                        </div>
                    </div>
                </aside>

                {{-- MAIN --}}
                <main class="col-span-12 lg:col-span-9">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between mb-6">
                        <div>
                            <h3 class="text-lg font-extrabold text-slate-900">Communauté Talentia</h3>
                            <p class="text-sm text-slate-500">Trouvez des profils et développez votre réseau.</p>
                        </div>

                        <div class="inline-flex items-center gap-2 rounded-full bg-white px-4 py-2 ring-1 ring-slate-200">
                            <span class="text-sm text-slate-500">Membres</span>
                            <span class="text-sm font-extrabold text-slate-900">{{ $users->count() }}</span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5">
                        @forelse($users as $u)
                            <div class="group rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 p-5 hover:ring-indigo-200 hover:shadow-md transition">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="flex items-center gap-3 min-w-0">
                                        @if($u->profile?->photo)
                                            <img src="{{ asset('storage/'.$u->profile->photo) }}" class="w-12 h-12 rounded-2xl object-cover">
                                        @else
                                            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-extrabold text-lg">
                                                {{ substr($u->name, 0, 1) }}
                                            </div>
                                        @endif

                                        <div class="min-w-0">
                                            <p class="font-extrabold text-slate-900 truncate group-hover:text-indigo-600 transition">
                                                {{ $u->name }}
                                            </p>
                                            <p class="text-xs font-bold text-slate-500 truncate">
                                                {{ $u->profile?->specialty ?? 'Talent Talentia' }}
                                            </p>
                                        </div>
                                    </div>

                                    <span class="shrink-0 px-2 py-1 rounded-lg text-[10px] font-black uppercase tracking-tight
                                        {{ $u->role === 'recruteur' ? 'bg-emerald-100 text-emerald-700' : 'bg-sky-100 text-sky-700' }}">
                                        {{ $u->role }}
                                    </span>
                                </div>

                                <p class="mt-4 text-sm text-slate-600 line-clamp-3 min-h-[60px]">
                                    {{ $u->profile?->bio ?? 'Pas encore de bio...' }}
                                </p>

                                <div class="mt-5 flex gap-2">
                                    <a href="{{ route('profile.show', $u->id) }}"
                                       class="flex-1 text-center py-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 transition text-sm font-extrabold text-slate-800">
                                        Profil
                                    </a>

                                    <form action="{{ route('friendship.send', $u->id) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button
                                            class="w-full py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 transition text-sm font-extrabold text-white shadow-sm"
                                        >
                                            Suivre
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="col-span-full">
                                <div class="rounded-2xl bg-white ring-1 ring-slate-200 p-10 text-center">
                                    <p class="text-slate-500 font-semibold">Aucun membre ne correspond à votre recherche.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </main>
            </div>
        </div>
    </div>
</x-app-layout>
