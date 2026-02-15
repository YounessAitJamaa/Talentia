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
                                    e         class="bg-indigo-600 text-white px-6 py-2 rounded-full font-bold hover:bg-indigo-700 transition">
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
                                @if(auth()->user()->hasPremium)
                                <img class="w-16 h-16"  src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse1.mm.bing.net%2Fth%2Fid%2FOIP.Vt5Gv3hQiBUdpEKNkOc_DQHaHa%3Fpid%3DApi&f=1&ipt=c96ee8da06930b2ac5aa42314594f48e491dfb39790293ba4058076efd8aaa0c&ipo=images" alt="premium">
                                @else
                                <a href="{{ route('subscribe') }}"
                                class="px-6 py-2 rounded-full border border-gray-300 font-bold hover:bg-gray-50 transition">
                                    Devenir premium
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

                    {{-- Experiences --}}
                    <div class="bg-white border border-slate-200 rounded-lg p-5">
                        <div class="flex items-center gap-2 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-900"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                            <h3 class="text-sm font-extrabold text-slate-900">Expérience professionnelle</h3>
                        </div>
                        <div class="space-y-6">
                            @forelse($user->experiences as $exp)
                                <div class="flex gap-4">
                                    <div class="shrink-0 w-12 h-12 bg-slate-50 border border-slate-100 rounded flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-bold text-slate-900">{{ $exp->position }}</h4>
                                        <p class="text-sm text-slate-700">{{ $exp->company }}</p>
                                        <p class="text-xs text-slate-500 mt-1 uppercase tracking-tight font-medium">
                                            {{ $exp->start_date?->format('M Y') ?? '—' }} – 
                                            {{ $exp->end_date ? $exp->end_date->format('M Y') : 'Présent' }}
                                        </p>
                                        @if($exp->description)
                                            <p class="mt-2 text-sm text-slate-600 leading-relaxed">{{ $exp->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-slate-500 italic">Aucune expérience renseignée.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Formations --}}
                    <div class="bg-white border border-slate-200 rounded-lg p-5">
                        <div class="flex items-center gap-2 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-900"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15a2.5 2.5 0 0 1 2.5-2.5Z"/><path d="M8 6h10"/><path d="M8 10h10"/><path d="M8 14h10"/></svg>
                            <h3 class="text-sm font-extrabold text-slate-900">Formations</h3>
                        </div>
                        <div class="space-y-6">
                            @forelse($user->education as $edu)
                                <div class="flex gap-4">
                                    <div class="shrink-0 w-12 h-12 bg-slate-50 border border-slate-100 rounded flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-bold text-slate-900">{{ $edu->school }}</h4>
                                        <p class="text-sm text-slate-700">{{ $edu->degree }} • {{ $edu->field_of_study }}</p>
                                        <p class="text-xs text-slate-500 mt-1 uppercase tracking-tight font-medium">
                                            {{ $edu->start_date?->format('Y') ?? '—' }} – 
                                            {{ $edu->end_date ? $edu->end_date->format('Y') : 'Présent' }}
                                        </p>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-slate-500 italic">Aucune formation renseignée.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- Skills --}}
                    <div class="bg-white border border-slate-200 rounded-lg p-5">
                        <div class="flex items-center gap-2 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-900"><path d="M6 16.5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16H8a2 2 0 0 1-2-2.5Z"/><path d="m9 10 2 2 4-4"/></svg>
                            <h3 class="text-sm font-extrabold text-slate-900">Compétences</h3>
                        </div>
                        <div class="flex flex-wrap gap-2">
                            @forelse($user->skills as $skill)
                                <span class="px-3 py-1 bg-slate-100 text-slate-700 text-sm font-medium rounded-full border border-slate-200">
                                    {{ $skill->name }}
                                </span>
                            @empty
                                <p class="text-sm text-slate-500 italic">Aucune compétence renseignée.</p>
                            @endforelse
                        </div>
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
