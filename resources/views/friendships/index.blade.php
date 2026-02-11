<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Invitations en attente</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @forelse($invitations as $invite)
                    <div class="flex items-center justify-between border-b pb-4 mb-4 last:border-0">
                        <div class="flex items-center gap-4">
                            <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center font-bold text-indigo-600">
                                {{ substr($invite->sender->name, 0, 1) }}
                            </div>
                            <div>
                                <h4 class="font-bold">{{ $invite->sender->name }}</h4>
                                <p class="text-sm text-gray-500">{{ $invite->sender->profile->specialty ?? 'Sans spécialité' }}</p>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <form action="{{ route('friendship.accept', $invite->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-bold hover:bg-indigo-700">
                                    Accepter
                                </button>
                            </form>
                            
                            </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500">Vous n'avez aucune invitation en attente.</p>
                @endforelse
            </div>

        </div>

            
    </div>
</x-app-layout>