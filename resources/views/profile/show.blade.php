<x-app-layout>
    <div class="min-h-screen bg-slate-100">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 py-6 space-y-4">

            {{-- PROFILE HEADER CARD --}}
            <div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
                {{-- Cover --}}
                <div class="h-28 sm:h-36 bg-gradient-to-r from-indigo-600 to-indigo-400"></div>

                <div class="p-5">
                    <div class="-mt-14 sm:-mt-16 flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
                        {{-- Left: avatar + identity --}}
                        <div class="flex items-end gap-4 min-w-0">
                            <div class="shrink-0">
                                @if($user->profile && $user->profile->photo)
                                    <img
                                        src="{{ asset('storage/' . $user->profile->photo) }}"
                                        class="w-24 h-24 sm:w-28 sm:h-28 rounded-full object-cover ring-4 ring-white border border-slate-200"
                                        alt="Photo"
                                    >
                                @else
                                    <div class="w-24 h-24 sm:w-28 sm:h-28 rounded-full bg-indigo-100 ring-4 ring-white border border-slate-200 flex items-center justify-center text-3xl sm:text-4xl font-extrabold text-indigo-700">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <div class="min-w-0 pb-1">
                                <h1 class="text-xl sm:text-2xl font-extrabold text-slate-900 truncate">
                                    {{ $user->name }}
                                </h1>

                                <p class="text-sm sm:text-base text-slate-700 font-semibold truncate">
                                    {{ $user->profile->specialty ?? 'Sans spécialité' }}
                                </p>

                                <div class="mt-2 flex flex-wrap items-center gap-2">
                                    <span class="text-[11px] font-black uppercase tracking-widest px-2 py-1 rounded
                                        {{ $user->role === 'recruteur' ? 'bg-emerald-50 text-emerald-700' : 'bg-sky-50 text-sky-700' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>

                                    {{-- Example meta line if you have it later:
                                    <span class="text-xs text-slate-500">Casablanca · Disponible</span>
                                    --}}
                                </div>
                            </div>
                        </div>

                        {{-- Right: actions --}}
                        <div class="flex gap-2">
                            @if(Auth::id() !== $user->id)

                                @if($status === 'accepted')
                                    <span class="px-6 py-2 rounded-full bg-emerald-50 text-emerald-700 font-bold">
                                        Connecté
                                    </span>

                                @elseif($status === 'pending')
                                    <button disabled class="px-6 py-2 rounded-full bg-slate-100 text-slate-500 font-bold cursor-not-allowed">
                                        En attente
                                    </button>

                                @else
                                    <form action="{{ route('friendship.send', $user->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="bg-indigo-600 text-white px-6 py-2 rounded-full font-bold hover:bg-indigo-700 transition">
                                            Suivre
                                        </button>
                                    </form>
                                @endif

                            @else
                                <a href="{{ route('profile.edit') }}"
                                class="px-6 py-2 rounded-full border border-gray-300 font-bold hover:bg-gray-50 transition">
                                    Modifier mon profil
                                </a>
                            @endif
                        </div>


                    </div>

                    {{-- Headline / short bio line (LinkedIn vibe) --}}
                    <div class="mt-4 text-sm text-slate-700">
                        {{ \Illuminate\Support\Str::limit($user->profile->bio ?? "Cet utilisateur n'a pas encore rédigé de bio.", 140) }}
                    </div>
                </div>
            </div>

            {{-- 2-column sections (like LinkedIn) --}}
            <div class="grid grid-cols-12 gap-4">
                {{-- MAIN --}}
                <main class="col-span-12 lg:col-span-8 space-y-4">
                    {{-- About --}}
                    <div class="bg-white border border-slate-200 rounded-lg p-5">
                        <h3 class="text-sm font-extrabold text-slate-900">À propos</h3>
                        <p class="mt-3 text-sm text-slate-700 leading-relaxed">
                            {{ $user->profile->bio ?? "Cet utilisateur n'a pas encore rédigé de bio." }}
                        </p>
                    </div>

                    {{-- Add more sections later (Experience / Skills / Projects) --}}
                    <div class="bg-white border border-slate-200 rounded-lg p-5">
                        <h3 class="text-sm font-extrabold text-slate-900">Informations</h3>
                        <div class="mt-3 text-sm text-slate-700 space-y-2">
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500">Spécialité</span>
                                <span class="font-semibold text-slate-900">{{ $user->profile->specialty ?? '—' }}</span>
                            </div>
                            {{-- Example fields if you add them later:
                            <div class="flex items-center justify-between">
                                <span class="text-slate-500">Téléphone</span>
                                <span class="font-semibold text-slate-900">{{ $user->profile->phone ?? '—' }}</span>
                            </div>
                            --}}
                        </div>
                    </div>
                </main>

                {{-- SIDEBAR --}}
                <aside class="col-span-12 lg:col-span-4 space-y-4">
                    {{-- Contact / actions card --}}
                    {{-- <div class="bg-white border border-slate-200 rounded-lg p-5">
                        <h3 class="text-sm font-extrabold text-slate-900">Actions</h3>
                        <div class="mt-4 grid grid-cols-1 gap-2">
                            @if(auth()->id() !== $user->id)
                                <form action="{{ route('friendship.send', $user->id) }}" method="POST">
                                    @csrf
                                    <button class="w-full px-5 py-2 rounded-full bg-indigo-600 text-white text-sm font-extrabold hover:bg-indigo-700 transition">
                                        Suivre
                                    </button>
                                </form>
                            @endif

                            {{-- <a href="{{ route('messages.show', $user->id) }}"
                               class="w-full text-center px-5 py-2 rounded-full border border-slate-300 bg-white hover:bg-slate-50 transition text-sm font-extrabold text-slate-800">
                                Message
                            </a> --}}
                        {{-- </div>
                    </div> --}}

                    {{-- Small “Profile card” info --}}
                    <div class="bg-white border border-slate-200 rounded-lg p-5">
                        <h3 class="text-sm font-extrabold text-slate-900">Résumé</h3>
                        <p class="mt-2 text-sm text-slate-700">
                            {{ $user->profile->specialty ?? 'Sans spécialité' }}
                        </p>
                        <p class="mt-2 text-xs text-slate-500">
                            Rôle: {{ ucfirst($user->role) }}
                        </p>
                    </div>
                </aside>
            </div>

        </div>
    </div>
</x-app-layout>
