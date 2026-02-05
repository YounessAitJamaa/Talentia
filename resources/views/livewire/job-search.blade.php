<div>
    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 overflow-hidden">
        {{-- Search --}}
        <div class="p-5 sm:p-6 border-b bg-white">
            <div class="relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/>
                    </svg>
                </span>

                <input
                    wire:model.live.debounce.300ms="search"
                    type="text"
                    placeholder="Rechercher un job ou une entreprise..."
                    class="w-full pl-11 pr-10 py-3 rounded-xl bg-slate-50 ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition"
                />

                <span wire:loading class="absolute inset-y-0 right-3 flex items-center text-slate-400">
                    <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                              d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </span>
            </div>
        </div>

        {{-- Jobs --}}
        <div class="p-5 sm:p-6">
            <ul class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($jobs as $job)
                    <li class="group rounded-2xl bg-white ring-1 ring-slate-200 p-4 hover:ring-indigo-200 hover:shadow-md transition">
                        <div class="flex gap-4">
                            {{-- Logo --}}
                            <div class="shrink-0">
                                @if($job->image)
                                    <img
                                        src="{{ asset('storage/' . $job->image) }}"
                                        class="w-14 h-14 rounded-2xl object-cover ring-1 ring-slate-200"
                                        alt="Logo"
                                    >
                                @else
                                    <div class="w-14 h-14 rounded-2xl bg-indigo-50 flex items-center justify-center font-extrabold text-indigo-600">
                                        {{ strtoupper(substr($job->company ?? 'C', 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <div class="min-w-0 flex-1">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="font-extrabold text-slate-900 truncate group-hover:text-indigo-600 transition">
                                            {{ $job->title }}
                                        </p>
                                        <p class="text-sm font-semibold text-slate-600 truncate">
                                            {{ $job->company }}
                                        </p>
                                    </div>

                                    <span class="shrink-0 inline-flex items-center rounded-xl px-2.5 py-1 text-[11px] font-black uppercase tracking-tight bg-slate-100 text-slate-700">
                                        {{ $job->contract_type }}
                                    </span>
                                </div>

                                <div class="mt-4 flex gap-2">
                                    <button
                                        wire:click="showJob({{ $job->id }})"
                                        class="flex-1 rounded-xl bg-slate-100 hover:bg-slate-200 transition py-2.5 text-sm font-extrabold text-slate-800"
                                    >
                                        Voir
                                    </button>

                                    <button
                                        class="flex-1 rounded-xl bg-indigo-600 hover:bg-indigo-700 transition py-2.5 text-sm font-extrabold text-white shadow-sm"
                                    >
                                        Postuler
                                    </button>
                                </div>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="md:col-span-2">
                        <div class="rounded-2xl bg-slate-50 ring-1 ring-slate-200 p-8 text-center">
                            <p class="text-slate-600 font-semibold">Aucune offre trouvée.</p>
                            <p class="text-sm text-slate-500 mt-1">Essayez un autre mot-clé.</p>
                        </div>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- MODAL --}}
    @if($open && $selectedJob)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="w-full max-w-2xl rounded-2xl bg-white shadow-2xl overflow-hidden">
                <div class="flex items-center justify-between px-6 py-4 border-b">
                    <div class="min-w-0">
                        <p class="font-extrabold text-slate-900 truncate">{{ $selectedJob->title }}</p>
                        <p class="text-sm font-semibold text-slate-500 truncate">{{ $selectedJob->company }}</p>
                    </div>

                    <button wire:click="closeModal" class="text-slate-500 hover:text-slate-900 text-xl">
                        ✕
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    <div class="flex flex-wrap gap-2">
                        <span class="inline-flex items-center rounded-xl px-3 py-1 text-xs font-black bg-slate-100 text-slate-700">
                            {{ $selectedJob->contract_type }}
                        </span>

                        @if(!empty($selectedJob->location))
                            <span class="inline-flex items-center rounded-xl px-3 py-1 text-xs font-bold bg-indigo-50 text-indigo-700">
                                {{ $selectedJob->location }}
                            </span>
                        @endif
                    </div>

                    <div class="prose max-w-none">
                        {{-- Use description field if you have it --}}
                        <p class="text-slate-700">
                            {{ $selectedJob->description ?? "Aucune description disponible pour l'instant." }}
                        </p>
                    </div>

                    <div class="pt-2 flex gap-2">
                        <button wire:click="closeModal"
                                class="flex-1 rounded-xl bg-slate-100 hover:bg-slate-200 transition py-2.5 text-sm font-extrabold text-slate-800">
                            Fermer
                        </button>

                        <button
                            class="flex-1 rounded-xl bg-indigo-600 hover:bg-indigo-700 transition py-2.5 text-sm font-extrabold text-white shadow-sm">
                            Postuler
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
