<div>
    <div class="p-6 bg-white rounded-lg shadow">
        <input 
            wire:model.live="search" 
            type="text" 
            placeholder="Search jobs..." 
            class="w-full p-2 border rounded-lg mb-4"
        >

        <ul class="space-y-4">
            @forelse($jobs as $job)
                <li class="p-4 bg-white border rounded-lg shadow-sm flex items-center space-x-4">
                    <img src="{{ asset('storage/' . $job->image) }}" 
                        alt="Logo" 
                        class="w-16 h-16 object-cover rounded-md border">

                    <div>
                        <strong class="text-xl text-indigo-600">{{ $job->title }}</strong>
                        <p class="text-gray-600 font-semibold">{{ $job->company }}</p>
                        <span class="inline-block bg-gray-100 text-gray-800 text-xs px-2 py-1 rounded">
                            {{ $job->contract_type }}
                        </span>
                    </div>
                </li>
            @empty
                <li class="text-gray-500">Aucune offre trouvée.</li>
            @endforelse
        </ul>
    </div>
</div>