<div class="p-6 bg-white border-b border-gray-200 mt-6">
    <div class="mb-4">
        <h3 class="text-lg font-medium text-gray-900">Compétences</h3>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    <div class="mb-4 flex">
        <input type="text" wire:model="skill_name" wire:keydown.enter="addSkill"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            placeholder="Ajouter une compétence (ex: Laravel, React)...">
        <button wire:click="addSkill" class="ml-2 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Ajouter
        </button>
    </div>

    <div class="flex flex-wrap gap-2">
        @foreach($skills as $skill)
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                {{ $skill->name }}
                <button wire:click="removeSkill({{ $skill->id }})"
                    class="ml-2 text-blue-500 hover:text-blue-700 focus:outline-none">
                    &times;
                </button>
            </span>
        @endforeach
    </div>
</div>