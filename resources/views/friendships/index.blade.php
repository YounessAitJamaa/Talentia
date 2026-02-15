<x-app-layout>
    <div class="pt-6 pb-8">
        <div class="max-w-7xl mx-auto px-4">
            {{-- MAIN CONTENT: Friend Requests --}}
            <main class="py-4">
                <div class="max-w-3xl mx-auto">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="text-blue-600 h-5 w-5">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h1 class="text-xl font-semibold text-gray-900">Demandes d'ami</h1>
                                        <p class="text-sm text-gray-500">{{ $invitations->count() }} invitations en
                                            attente</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="divide-y divide-gray-200">
                            @forelse($invitations as $invite)
                                <div class="p-6 hover:bg-gray-50 transition-colors">
                                    <div class="flex items-start gap-4">
                                        @if($invite->sender->profile?->photo)
                                            <img src="{{ asset('storage/' . $invite->sender->profile->photo) }}"
                                                alt="{{ $invite->sender->name }}"
                                                class="h-16 w-16 rounded-full object-cover border border-gray-200 shadow-sm" />
                                        @else
                                            <div
                                                class="h-16 w-16 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-xl border border-blue-50">
                                                {{ strtoupper(substr($invite->sender->name, 0, 1)) }}
                                            </div>
                                        @endif

                                        <div class="flex-1">
                                            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                                                <div>
                                                    <h3
                                                        class="font-semibold text-gray-900 text-lg hover:text-blue-600 cursor-pointer">
                                                        <a
                                                            href="{{ route('profile.show', $invite->sender->id) }}">{{ $invite->sender->name }}</a>
                                                    </h3>
                                                    <p class="text-sm text-gray-600">
                                                        {{ $invite->sender->profile->specialty ?? 'Talent' }}
                                                    </p>
                                                    <div class="mt-2 flex items-center text-xs text-gray-500">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                                            viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                            class="mr-1 text-gray-400">
                                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                                            <circle cx="9" cy="7" r="4"></circle>
                                                        </svg>
                                                        Récemment envoyé
                                                    </div>
                                                </div>

                                                <div class="flex gap-2 shrink-0">
                                                    <form action="{{ route('friendship.accept', $invite->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all shadow-lg shadow-blue-100 font-medium text-sm flex items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round">
                                                                <polyline points="20 6 9 17 4 12"></polyline>
                                                            </svg>
                                                            Accepter
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('friendship.reject', $invite->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        <button type="submit"
                                                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-all font-medium text-sm flex items-center gap-2">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round"
                                                                stroke-linejoin="round">
                                                                <path d="M18 6 6 18"></path>
                                                                <path d="m6 6 12 12"></path>
                                                            </svg>
                                                            Décliner
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="py-12 text-center text-gray-500 bg-gray-50/30">
                                    <div
                                        class="mb-4 inline-flex items-center justify-center h-16 w-16 rounded-full bg-gray-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" class="text-gray-400">
                                            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                                            <circle cx="9" cy="7" r="4"></circle>
                                            <line x1="19" y1="8" x2="19" y2="14"></line>
                                            <line x1="22" y1="11" x2="16" y2="11"></line>
                                        </svg>
                                    </div>
                                    <p class="font-medium text-gray-600">Aucune invitation en attente</p>
                                    <p class="text-sm mt-1">Vos nouvelles demandes apparaîtront ici.</p>
                                </div>
                            @endforelse
                        </div>
                        {{-- JOB APPLICATION UPDATES --}}
                        @if($jobUpdates->isNotEmpty())
                            <div class="mt-8 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                                <div class="p-6 border-b border-gray-200 bg-gray-50/50">
                                    <div class="flex items-center gap-3">
                                        <div class="h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round" class="text-indigo-600">
                                                <rect width="20" height="14" x="2" y="7" rx="2" ry="2" />
                                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h2 class="text-xl font-semibold text-gray-900">Mises à jour de candidatures
                                            </h2>
                                            <p class="text-sm text-gray-500">Décisions récentes sur vos offres postulées</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="divide-y divide-gray-200">
                                    @foreach($jobUpdates as $update)
                                        <div class="p-6 hover:bg-gray-50 transition-colors">
                                            <div class="flex items-center justify-between gap-4">
                                                <div class="flex items-center gap-4">
                                                    <div
                                                        class="h-12 w-12 rounded-lg bg-gray-100 flex items-center justify-center border border-gray-200 overflow-hidden">
                                                        @if($update->job->image)
                                                            <img src="{{ asset('storage/' . $update->job->image) }}"
                                                                class="h-full w-full object-cover">
                                                        @else
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                                class="text-gray-400">
                                                                <rect width="20" height="14" x="2" y="7" rx="2" ry="2" />
                                                                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                                                            </svg>
                                                        @endif
                                                    </div>
                                                    <div>
                                                        <h3 class="font-semibold text-gray-900">{{ $update->job->title }}</h3>
                                                        <p class="text-sm text-gray-500">{{ $update->job->company }}</p>
                                                    </div>
                                                </div>

                                                <div class="flex flex-col items-end gap-1 text-right">
                                                    @if($update->status === 'accepted')
                                                        <span
                                                            class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-green-100 text-green-800">
                                                            Candidature Acceptée
                                                        </span>
                                                        <p class="text-xs text-gray-400 mt-1">Le recruteur vous contactera bientôt.
                                                        </p>
                                                    @else
                                                        <span
                                                            class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-red-100 text-red-800">
                                                            Candidature Refusée
                                                        </span>
                                                        <p class="text-xs text-gray-400 mt-1">Bonne chance pour vos prochaines
                                                            recherches.</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
</x-app-layout>