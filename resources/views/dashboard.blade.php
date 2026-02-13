<x-app-layout>
    <div class="min-h-screen bg-slate-100">
        {{-- Top bar --}}
        <div class="sticky top-0 z-40 border-b bg-white">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 py-3 flex items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded bg-indigo-600"></div>
                    <div class="hidden sm:block">
                        <p class="text-sm font-extrabold text-slate-900">Talentia</p>
                        <p class="text-xs text-slate-500 -mt-0.5">Dashboard</p>
                    </div>
                </div>

                @role('recruteur')
                <div x-data="{ open: false }" class="flex items-center gap-2">
                    <button @click="open = true"
                        class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-indigo-600 text-white text-sm font-extrabold hover:bg-indigo-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Publier une offre
                    </button>

                    {{-- Modal --}}
                    <div x-show="open" x-cloak
                        class="fixed inset-0 z-50 bg-black/50 flex items-center justify-center p-4">
                        <div @click.away="open=false"
                            class="w-full max-w-2xl bg-white rounded-xl shadow-2xl overflow-hidden">
                            <div class="px-5 py-4 border-b flex items-center justify-between">
                                <h3 class="font-extrabold text-slate-900">Nouvelle offre</h3>
                                <button @click="open=false" class="text-slate-500 hover:text-slate-900">✕</button>
                            </div>
                            <div class="p-5 max-h-[80vh] overflow-y-auto">
                                <livewire:post-job />
                            </div>
                        </div>
                    </div>
                </div>
                @endrole
            </div>
        </div>

        {{-- 3 column layout --}}
        <div class="mx-auto px-4 sm:px-6 py-6">
            <div class="grid grid-cols-12 gap-6">

                {{-- LEFT: Profile --}}
                <aside class="col-span-12 md:col-span-4 lg:col-span-3 space-y-4">
                    <div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
                        <div class="h-32 bg-gradient-to-r from-indigo-600 to-indigo-400"></div>

                        <div class="p-4">
                            <div class="-mt-9 flex items-end gap-3">
                                @if(auth()->user()->profile?->photo)
                                    <img src="{{ asset('storage/' . auth()->user()->profile->photo) }}"
                                        class="w-16 h-16 rounded-full object-cover ring-4 ring-white border border-slate-200">
                                @else
                                    <div
                                        class="w-16 h-16 rounded-full bg-indigo-100 flex items-center justify-center font-extrabold text-indigo-700 text-2xl ring-4 ring-white border border-slate-200">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>


                                @endif
                            </div>

                            <div class="mt-3">
                                <p class="font-extrabold text-[30px] text-slate-900">{{ auth()->user()->name }}</p>
                                <h1 class="text-lg text-slate-600">
                                    {{ auth()->user()->profile?->specialty ?? 'Talent Talentia' }}
                                </h1>
                                <p
                                    class="mt-2 inline-flex text-[15px] font-black uppercase tracking-widest text-indigo-700 bg-indigo-50 px-2 py-1 rounded">
                                    {{ auth()->user()->role }}
                                </p>
                            </div>

                            <div class="mt-4 flex gap-2">
                                <a href="{{ route('profile.show', auth()->id()) }}"
                                    class="flex-1 text-center text-sm font-extrabold px-3 py-2 rounded-full bg-slate-900 text-white hover:bg-slate-800 transition">
                                    Profil
                                </a>
                                <a href="{{ route('dashboard') }}"
                                    class="flex-1 text-center text-sm font-extrabold px-3 py-2 rounded-full border border-slate-300 hover:bg-slate-50 transition">
                                    Actualiser
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- Quick filters (LinkedIn-like) --}}
                    <div class="bg-white border border-slate-200 rounded-lg p-4">
                        <h4 class="text-sm font-extrabold text-slate-900">Communauté</h4>
                        <p class="text-xs text-slate-500 mt-1">Filtrer les membres</p>

                        <form action="{{ route('dashboard') }}" method="GET" class="mt-3 space-y-2">
                            @foreach(['Tous' => '', 'Chercheurs' => 'chercheur', 'Recruteurs' => 'recruteur'] as $label => $val)
                                <button type="submit" name="role" value="{{ $val }}"
                                    class="w-full text-left px-3 py-2 rounded-md text-sm font-semibold border
                                        {{ request('role') == $val ? 'bg-indigo-50 border-indigo-200 text-indigo-700' : 'bg-white border-slate-200 text-slate-700 hover:bg-slate-50' }}">
                                    {{ $label }}
                                </button>
                            @endforeach
                        </form>
                    </div>
                </aside>

                {{-- CENTER: Feed (Jobs search) --}}
                <main class="col-span-12 md:col-span-8 lg:col-span-6 space-y-4">
                    {{-- Feed intro card --}}
                    <div class="bg-white border border-slate-200 rounded-lg p-4">
                        <p class="text-sm text-slate-600">
                            Bonjour <span class="font-extrabold text-slate-900">{{ auth()->user()->name }}</span>,
                            recherchez des offres et développez votre réseau.
                        </p>
                    </div>

                    {{-- Jobs Search Feed --}}
                    <div>
                        @livewire('job-search')
                    </div>
                </main>

                {{-- RIGHT: Suggestions / People --}}
                <aside class="col-span-12 lg:col-span-3 space-y-4">
                    <div class="bg-white border border-slate-200 rounded-lg p-4">
                        <div class="flex items-center justify-between">
                            <h4 class="text-sm font-extrabold text-slate-900">People you may know</h4>
                            <span class="text-xs text-slate-500">{{ $users->count() }} membres</span>
                        </div>

                        <div class="mt-3 space-y-3">
                            @forelse($users->take(6) as $u)
                                <div class="flex items-center gap-3">
                                    @if($u->profile?->photo)
                                        <img src="{{ asset('storage/' . $u->profile->photo) }}"
                                            class="w-10 h-10 rounded-full object-cover border border-slate-200">
                                    @else
                                        <div
                                            class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-extrabold text-slate-700">
                                            {{ strtoupper(substr($u->name, 0, 1)) }}

                                        </div>
                                    @endif

                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-extrabold text-slate-900 truncate">{{ $u->name }}</p>

                                        <p class="text-xs text-slate-500 truncate">
                                            {{ $u->profile?->specialty ?? 'Talent Talentia' }}</p>

                                    </div>

                                    <form action="{{ route('friendship.send', $u->id) }}" method="POST">
                                        @csrf
                                        <button
                                            class="px-3 py-1.5 rounded-full bg-indigo-600 hover:bg-indigo-700 transition text-xs font-extrabold text-white">
                                            Suivre
                                        </button>
                                    </form>
                                </div>
                            @empty
                                <p class="text-sm text-slate-500">Aucun membre.</p>
                            @endforelse
                        </div>

                        <a href="{{ route('community.index') }}"
                            class="mt-4 w-full block text-center py-2 text-sm font-bold text-indigo-600 hover:text-indigo-700 hover:bg-indigo-50 rounded-xl border border-indigo-100 transition-all">
                            Voir plus
                        </a>
                    </div>
            </div>

            </aside>

        </div>
    </div>
    </div>

    <!-- <script>
        Echo.channel('user.{{ auth()->id() }}')
            .listen('FriendRequestSent', (e) => {
                alert(e.sender.name + " sent you a friend request!");
            });
    </script> -->
</x-app-layout>