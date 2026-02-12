<x-app-layout>
    <div class="min-h-screen bg-slate-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6 space-y-4">

            {{-- Page header --}}
            <div class="bg-white border border-slate-200 rounded-lg p-4">
                <h1 class="text-lg font-extrabold text-slate-900">Communauté</h1>
                <p class="text-sm text-slate-600">Recherchez des membres et connectez-vous.</p>
            </div>

            {{-- Search --}}
            <div class="bg-white border border-slate-200 rounded-lg p-4">
                <form method="GET" action="{{ route('community.index') }}" class="flex gap-3">
                    <input
                        name="q"
                        value="{{ $q ?? '' }}"
                        placeholder="Rechercher par nom, spécialité..."
                        class="flex-1 px-3 py-2 rounded-md border border-slate-200 bg-slate-50 focus:bg-white focus:border-indigo-400 focus:ring-2 focus:ring-indigo-100 outline-none transition text-sm"
                    >
                    <button class="px-5 py-2 rounded-md bg-indigo-600 hover:bg-indigo-700 transition text-sm font-extrabold text-white">
                        Chercher
                    </button>
                </form>
            </div>

            {{-- Users --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($users as $u)
                    <div class="bg-white border border-slate-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            @if($u->profile?->photo)
                                <img src="{{ asset('storage/'.$u->profile->photo) }}"
                                     class="w-12 h-12 rounded-full object-cover border border-slate-200">
                            @else
                                <div class="w-12 h-12 rounded-full bg-slate-100 flex items-center justify-center font-extrabold text-slate-700">
                                    {{ strtoupper(substr($u->name, 0, 1)) }}
                                </div>
                            @endif

                            <div class="min-w-0 flex-1">
                                <div class="flex items-start justify-between gap-2">
                                    <div class="min-w-0">
                                        <p class="text-sm font-extrabold text-slate-900 truncate">{{ $u->name }}</p>
                                        <p class="text-xs text-slate-500 truncate">{{ $u->profile?->specialty ?? 'Talent Talentia' }}</p>
                                    </div>

                                    <span class="text-[10px] font-black uppercase px-2 py-1 rounded
                                        {{ $u->role === 'recruteur' ? 'bg-emerald-50 text-emerald-700' : 'bg-sky-50 text-sky-700' }}">
                                        {{ $u->role }}
                                    </span>
                                </div>
                               
                                <!-- Indicateur de statut en ligne/hors ligne -->
                                <div class="mt-2 flex items-center gap-2">
                                    <span class="text-xs text-gray-600">Statut:</span>
                                    <span id="status-indicator-{{ $u->id }}" data-status-dot="{{ $u->id }}" class="w-3 h-3 rounded-full 
                                        {{ $u->status === 'online' ? 'bg-green-500' : 'bg-gray-500' }}"></span>
                                    <span id="status-text-{{ $u->id }}" data-status-text="{{ $u->id }}" class="text-xs {{ $u->status === 'online' ? 'text-green-600' : 'text-gray-500' }}">
                                        {{ $u->status === 'online' ? 'En ligne' : 'Hors ligne' }}
                                    </span>
                                </div>

                                <div class="mt-3 flex gap-2">
                                    <a href="{{ route('profile.show', $u->id) }}"
                                       class="px-4 py-2 rounded-full border border-slate-300 hover:bg-slate-50 transition text-xs font-extrabold">
                                        Voir
                                    </a>

                                    @php
                                        $status = $friendshipMap[$u->id] ?? null; // null / pending / accepted
                                    @endphp

                                    @if(Auth::id() !== $u->id)

                                        @if($status === 'accepted')
                                            <a href="{{ route('messages.show', $u->id) }}"
                                            class="px-3 py-1.5 rounded-full border border-slate-300 hover:bg-slate-50 transition text-xs font-extrabold">
                                                Message
                                            </a>

                                        @elseif($status === 'pending')
                                            <button
                                                class="px-3 py-1.5 rounded-full bg-slate-100 text-slate-500 text-xs font-extrabold cursor-not-allowed">
                                                En attente
                                            </button>

                                        @else
                                            <form action="{{ route('friendship.send', $u->id) }}" method="POST">
                                                @csrf
                                                <button class="px-3 py-1.5 rounded-full bg-indigo-600 hover:bg-indigo-700 transition text-xs font-extrabold text-white">
                                                    Suivre
                                                </button>
                                            </form>
                                        @endif

                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full bg-white border border-slate-200 rounded-lg p-8 text-center text-slate-500">
                        Aucun utilisateur trouvé.
                    </div>
                @endforelse
            </div>

            <div>
                {{ $users->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
