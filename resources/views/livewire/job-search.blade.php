<div>
    <div class="p-6 bg-white rounded-lg shadow">
        <input 
            wire:model.live="search" 
            type="text" 
            placeholder="Search jobs..." 
            class="w-full p-2 border rounded-lg mb-4"
        >

        <ul class="space-y-2">
            @forelse($jobs as $job)
                <li class="p-4 border-b">
                    <strong>{{ $job->title }}</strong> - {{ $job->company }}
                </li>
            @empty
                <li class="text-gray-500">No jobs found for "{{ $search }}"</li>
            @endforelse
        </ul>
    </div>
</div>