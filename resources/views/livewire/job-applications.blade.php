<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="px-4 py-6 sm:px-0">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Candidatures pour : {{ $job->title }}</h1>
            <a href="{{ route('recruiter.dashboard') }}"
                class="text-indigo-600 hover:text-indigo-900 font-medium">&larr; Retour au tableau de bord</a>
        </div>

        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @forelse($applications as $application)
                    <li>
                        <div class="px-4 py-4 sm:px-6">
                            <div class="flex items-center justify-between">
                                <h3 class="text-lg font-medium text-gray-900">
                                    {{ $application->user->name }}
                                </h3>
                                <p class="text-sm text-gray-500">
                                    Postulé le {{ $application->created_at->format('d/m/Y') }}
                                </p>
                            </div>
                            <div class="mt-2">
                                <p class="text-sm text-gray-600 mb-2">
                                    <span class="font-bold">Email:</span> {{ $application->user->email }}
                                </p>
                                @if($application->user->profile)
                                    <p class="text-sm text-gray-600 mb-2">
                                        <span class="font-bold">Spécialité:</span> {{ $application->user->profile->specialty }}
                                    </p>
                                @endif

                                <div class="bg-gray-50 p-3 rounded text-sm text-gray-700 mb-3">
                                    <span class="font-bold block mb-1">Message:</span>
                                    {{ $application->message ?? 'Aucun message.' }}
                                </div>

                                <div class="mt-4">
                                    <a href="{{ asset('storage/' . $application->cv_path) }}" target="_blank"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Télécharger le CV
                                    </a>
                                    <a href="{{ route('profile.show', $application->user->id) }}"
                                        class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Voir le profil complet
                                    </a>
                                </div>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="px-4 py-4 sm:px-6 text-center text-gray-500">
                        Aucune candidature reçue pour le moment.
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</div>