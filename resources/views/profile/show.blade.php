<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Profil de {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-200">
                <div class="h-32 bg-gradient-to-r from-indigo-500 to-purple-600"></div>
                
                <div class="p-6 relative">
                    <div class="absolute -top-16 left-6">
                        @if($user->profile && $user->profile->photo)
                            <img src="{{ asset('storage/' . $user->profile->photo) }}" class="w-32 h-32 rounded-full border-4 border-white object-cover shadow-md">
                        @else
                            <div class="w-32 h-32 bg-indigo-100 rounded-full border-4 border-white flex items-center justify-center text-4xl font-bold text-indigo-600 shadow-md">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                        @endif
                    </div>

                    <div class="mt-16 flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                            <p class="text-indigo-600 font-semibold">{{ $user->profile->specialty ?? 'Sans spécialité' }}</p>
                            <p class="text-gray-500 text-sm italic">{{ ucfirst($user->role) }}</p>
                        </div>

                        <div class="flex gap-2">
                             <form action="{{ route('friendship.send', $user->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-full font-bold hover:bg-indigo-700 transition">
                                    Se connecter
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="mt-8 border-t pt-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">À propos</h3>
                        <p class="text-gray-600 leading-relaxed">
                            {{ $user->profile->bio ?? 'Cet utilisateur n\'a pas encore rédigé de bio.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>