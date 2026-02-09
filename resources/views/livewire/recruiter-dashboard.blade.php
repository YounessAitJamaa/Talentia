<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Mes Offres d'Emploi</h1>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @forelse($jobs as $job)
                    <li>
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-medium text-indigo-600 truncate">
                                    {{ $job->title }}
                                </p>
                                <div class="ml-2 flex-shrink-0 flex">
                                    <p
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $job->is_closed ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                        {{ $job->is_closed ? 'Clôturée' : 'Active' }}
                                    </p>
                                </div>
                            </div>
                            <div class="mt-2 sm:flex sm:justify-between">
                                <div class="sm:flex">
                                    <p class="flex items-center text-sm text-gray-500">
                                        {{ $job->contract_type }}
                                    </p>
                                    <p class="mt-2 flex items-center text-sm text-gray-500 sm:mt-0 sm:ml-6">
                                        Candidatures: {{ $job->applications_count }}
                                    </p>
                                </div>
                                <div class="mt-2 flex items-center text-sm sm:mt-0 space-x-2">
                                    <a href="{{ route('job.applications', $job->id) }}"
                                        class="text-indigo-600 hover:text-indigo-900">Voir Candidatures</a>

                                    @if(!$job->is_closed)
                                        <button wire:click="closeJob({{ $job->id }})"
                                            class="text-orange-600 hover:text-orange-900 ml-4">Clôturer</button>
                                    @endif

                                    <button wire:click="deleteJob({{ $job->id }})"
                                        class="text-red-600 hover:text-red-900 ml-4"
                                        onclick="confirm('Êtes-vous sûr ?') || event.stopImmediatePropagation()">Supprimer</button>
                                </div>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-4 sm:px-6 text-center text-gray-500">
                        Vous n'avez publié aucune offre.
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>