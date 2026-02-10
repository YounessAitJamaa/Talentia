<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes Amis') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($friends->isEmpty())
                        <p>Vous n'avez pas encore d'amis.</p>
                    @else
                        <ul class="divide-y divide-gray-200">
                            @foreach($friends as $friend)
                                <li class="py-4">
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            <!-- Display friend's profile picture and name -->
                                            @if($friend->profile && $friend->profile->photo)
                                                <img src="{{ asset('storage/' . $friend->profile->photo) }}" alt="Profile Picture"
                                                    class="w-24 h-24 rounded-full border border-gray-200 object-cover">
                                            @else
                                                <img src="/images/default-avatar.png" alt="Default Avatar"
                                                    class="w-24 h-24 rounded-full border border-gray-200 object-cover">
                                            @endif
                                            <span class="ml-3 font-medium text-gray-900">{{ $friend->name }}</span>
                                        </div>
                                        <div>
                                            <a href="{{ route('messages.show', $friend->id) }}"
                                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">Message</a>

                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="mt-4 flex justify-center">
                        {{ $friends->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>