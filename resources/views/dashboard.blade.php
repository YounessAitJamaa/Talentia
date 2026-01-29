<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    {{-- Make sure this matches the 'users' variable from your Route/Controller --}}
    @forelse($users as $u)
        <div class="bg-white border rounded-lg shadow-sm p-5 flex flex-col items-center">
            
            {{-- Photo Display --}}
            @if($u->profile && $u->profile->photo)
                <img src="{{ asset('storage/' . $u->profile->photo) }}" class="w-20 h-20 rounded-full object-cover mb-4">
            @else
                <div class="w-20 h-20 bg-gray-200 rounded-full mb-4 flex items-center justify-center text-xl font-bold text-gray-500">
                    {{ substr($u->name, 0, 1) }}
                </div>
            @endif
            
            <h4 class="text-lg font-bold">{{ $u->name }}</h4>
            
            <p class="text-indigo-600 font-medium text-sm">
                {{ $u->profile->specialty ?? 'Sans spécialité' }}
            </p>
            
            <p class="text-gray-500 text-sm text-center mt-2 line-clamp-2">
                {{ $u->profile->bio ?? 'Aucune bio disponible.' }}
            </p>

            <a href="{{ route('profile.show', $u->id) }}" class="mt-4 w-full inline-flex justify-center bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700 transition">
                Voir le profil
            </a>
        </div>
    @empty
        <p class="col-span-3 text-center text-gray-500">Aucun utilisateur trouvé.</p>
    @endforelse
</div>