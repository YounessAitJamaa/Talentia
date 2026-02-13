<div>
    <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 overflow-hidden">
        {{-- Search --}}
        <div class="p-5 sm:p-6 border-b bg-white">
            <div class="relative">
                <span class="absolute inset-y-0 left-3 flex items-center text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
                    </svg>
                </span>

                <input wire:model.live.debounce.300ms="search" type="text"
                    placeholder="Rechercher un job ou une entreprise..."
                    class="w-full pl-11 pr-10 py-3 rounded-xl bg-slate-50 ring-1 ring-slate-200 focus:bg-white focus:ring-2 focus:ring-indigo-500 outline-none transition" />

                <span wire:loading class="absolute inset-y-0 right-3 flex items-center text-slate-400">
                    <svg class="w-5 h-5 animate-spin" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </span>
            </div>
        </div>

        {{-- Jobs --}}
        <div class="p-5 sm:p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($jobs as $job)
                    <div
                        class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition-shadow group">
                        {{-- Top Section: Image/Media --}}
                        <div class="relative h-48 bg-slate-100">
                            @if($job->image)
                                <img src="{{ asset('storage/' . $job->image) }}" alt="{{ $job->title }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-indigo-50 text-indigo-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <rect width="20" height="14" x="2" y="7" rx="2" ry="2" />
                                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                                    </svg>
                                </div>
                            @endif

                            {{-- Badges Overlays --}}
                            <div class="absolute bottom-3 left-3 flex gap-2">
                                <span
                                    class="bg-white/90 backdrop-blur-sm px-2.5 py-1 rounded-lg text-[11px] font-extrabold uppercase tracking-wider text-indigo-700 shadow-sm">
                                    {{ $job->contract_type }}
                                </span>
                            </div>

                            @if(Auth::check() && Auth::user()->role === 'chercheur')
                                <button
                                    class="absolute top-3 right-3 p-2 rounded-full bg-white/80 backdrop-blur-sm text-gray-400 hover:text-red-500 hover:bg-white transition-all shadow-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M19 21l-7-4-7 4V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16z"></path>
                                    </svg>
                                </button>
                            @endif
                        </div>

                        {{-- Bottom Section: Info --}}
                        <div class="p-5">
                            <h3
                                class="text-lg font-bold text-gray-900 mb-1 group-hover:text-indigo-600 transition-colors line-clamp-1">
                                {{ $job->title }}
                            </h3>
                            <p class="text-sm text-gray-500 font-semibold mb-4 flex items-center gap-1.5">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="text-gray-400">
                                    <rect width="18" height="12" x="3" y="10" rx="2" ry="2" />
                                    <path d="M7 10V4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v6" />
                                </svg>
                                {{ $job->company }}
                            </p>

                            <p class="text-sm text-gray-600 mb-5 line-clamp-2 leading-relaxed">
                                {{ $job->description ?? "Aucune description disponible pour l'instant. Cliquez sur 'Voir' pour en savoir plus sur cette opportunité." }}
                            </p>

                            <div class="space-y-2.5 mb-6">
                                <div class="flex items-center gap-2.5 text-[13px] text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="text-indigo-500">
                                        <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z" />
                                        <circle cx="12" cy="10" r="3" />
                                    </svg>
                                    {{ $job->location ?? 'Maroc' }}
                                </div>
                                <div class="flex items-center gap-2.5 text-[13px] text-gray-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="text-indigo-500">
                                        <circle cx="12" cy="12" r="10" />
                                        <polyline points="12 6 12 12 16 14" />
                                    </svg>
                                    Publié il y a {{ $job->created_at->diffForHumans() }}
                                </div>
                            </div>

                            <div class="flex items-center justify-between gap-4 pt-4 border-t border-gray-100">
                                <button wire:click="showJob({{ $job->id }})"
                                    class="text-indigo-600 text-sm font-bold hover:text-indigo-700 transition-colors flex items-center gap-1">
                                    Détails
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="m9 18 6-6-6-6" />
                                    </svg>
                                </button>

                                @if(Auth::check() && Auth::user()->role === 'chercheur')
                                    <livewire:apply-job :job="$job" :key="'apply-list-' . $job->id" />
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-1 md:col-span-2 py-12 flex flex-col items-center justify-center bg-slate-50 rounded-2xl border-2 border-dashed border-slate-200">
                        <div
                            class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center text-slate-400 mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="11" cy="11" r="8" />
                                <path d="m21 21-4.3-4.3" />
                            </svg>
                        </div>
                        <p class="text-slate-600 font-bold">Aucune offre trouvée.</p>
                        <p class="text-sm text-slate-500">Essayez d'ajuster vos filtres de recherche.</p>
                    </div>
                @endforelse
            </div>
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
                        <span
                            class="inline-flex items-center rounded-xl px-3 py-1 text-xs font-black bg-slate-100 text-slate-700">
                            {{ $selectedJob->contract_type }}
                        </span>

                        @if(!empty($selectedJob->location))
                            <span
                                class="inline-flex items-center rounded-xl px-3 py-1 text-xs font-bold bg-indigo-50 text-indigo-700">
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

                        @if(Auth::check() && Auth::user()->role === 'chercheur')
                            <livewire:apply-job :job="$selectedJob" :key="'apply-modal-' . $selectedJob->id" />
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>