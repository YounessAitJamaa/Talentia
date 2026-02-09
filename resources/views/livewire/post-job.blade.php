<div class="bg-white p-2">
    <div class="mb-6">
        <h2 class="text-xl font-bold text-gray-900">Nouvelle offre d'emploi</h2>
        <p class="text-sm text-gray-500">Remplissez les informations pour attirer les meilleurs talents.</p>
    </div>

    <form wire:submit.prevent="save" class="space-y-5">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-700">Titre du poste *</label>
                <input type="text" wire:model="title" placeholder="ex: Développeur Fullstack"
                    class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('title') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700">Entreprise *</label>
                <input type="text" wire:model="company" placeholder="Nom de votre société"
                    class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                @error('company') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700">Type de contrat *</label>
            <select wire:model="contract_type"
                class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">Sélectionnez le type</option>
                <option value="CDI">CDI</option>
                <option value="CDD">CDD</option>
                <option value="Full-time">Full-time</option>
                <option value="Stage">Stage</option>
                <option value="Freelance">Freelance</option>
            </select>
            @error('contract_type') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700">Description détaillée *</label>
            <textarea wire:model="description" rows="5" placeholder="Missions, environnement technique, avantages..."
                class="mt-1 block w-full border-gray-300 rounded-xl shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            @error('description') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Compétences requises</label>
            <div class="flex flex-wrap gap-2">
                @foreach($availableSkills as $skill)
                    <label
                        class="cursor-pointer inline-flex items-center px-3 py-1 rounded-full text-sm font-medium transition-colors
                            {{ in_array($skill->id, $selectedSkills) ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">
                        <input type="checkbox" wire:model="selectedSkills" value="{{ $skill->id }}" class="hidden">
                        {{ $skill->name }}
                    </label>
                @endforeach
            </div>
            @if(count($availableSkills) === 0)
                <p class="text-sm text-gray-500 italic">Aucune compétence disponible.</p>
            @endif
        </div>

        <div class="p-4 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
            <label class="block text-sm font-bold text-gray-700 mb-2">Image de l'offre (Obligatoire) *</label>
            <input type="file" wire:model="image" id="image_upload" class="hidden">

            <div class="flex items-center gap-4">
                <button type="button" onclick="document.getElementById('image_upload').click()"
                    class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-semibold text-gray-700 hover:bg-gray-50 transition">
                    Choisir un fichier
                </button>

                <div wire:loading wire:target="image" class="text-xs text-indigo-600 font-bold animate-pulse">
                    Chargement...
                </div>

                @if ($image)
                    <div class="relative">
                        <img src="{{ $image->temporaryUrl() }}"
                            class="w-16 h-16 rounded-lg object-cover border-2 border-white shadow-sm">
                        <span class="absolute -top-2 -right-2 bg-green-500 text-white rounded-full p-1">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M5 13l4 4L19 7" />
                            </svg>
                        </span>
                    </div>
                @endif
            </div>
            @error('image') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
        </div>

        <button type="submit" wire:loading.attr="disabled"
            class="w-full py-4 bg-indigo-600 text-white font-extrabold rounded-xl hover:bg-indigo-700 shadow-lg transition-all transform active:scale-95 disabled:opacity-50">
            <span wire:loading.remove wire:target="save">Publier l'annonce maintenant</span>
            <span wire:loading wire:target="save">Publication en cours...</span>
        </button>
    </form>
</div>