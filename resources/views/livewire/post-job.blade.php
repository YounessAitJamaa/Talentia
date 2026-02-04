<div> 
    <div class="max-w-2xl mx-auto p-6 bg-white rounded-xl shadow-md">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Publier une offre d'emploi</h2>

        <form wire:submit.prevent="save" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Titre du poste</label>
                <input type="text" wire:model="title" class="w-full mt-1 border-gray-300 rounded-md shadow-sm">
                @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Logo / Image</label>
                <input type="file" wire:model="image" class="mt-1">
                <div wire:loading wire:target="image" class="text-sm text-gray-500">Chargement de l'image...</div>
                @if ($image)
                    <div class="mt-2">
                        <img src="{{ $image->temporaryUrl() }}" class="w-20 h-20 rounded-md object-cover border">
                    </div>
                @endif
                @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 transition">
                Publier l'annonce
            </button>
        </form>
    </div>
</div> 
