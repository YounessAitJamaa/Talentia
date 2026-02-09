<div class="p-6 bg-white border-b border-gray-200">
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-lg font-medium text-gray-900">Formation</h3>
        <button wire:click="create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Ajouter une formation
        </button>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('message') }}</span>
        </div>
    @endif

    @if($isOpen)
        <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="mb-4">
                            <label for="school" class="block text-gray-700 text-sm font-bold mb-2">École /
                                Université:</label>
                            <input type="text" wire:model="school"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="school">
                            @error('school') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="degree" class="block text-gray-700 text-sm font-bold mb-2">Diplôme:</label>
                            <input type="text" wire:model="degree"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="degree">
                            @error('degree') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="mb-4">
                            <label for="field_of_study" class="block text-gray-700 text-sm font-bold mb-2">Domaine
                                d'études:</label>
                            <input type="text" wire:model="field_of_study"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                id="field_of_study">
                            @error('field_of_study') <span class="text-red-500">{{ $message }}</span>@enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="mb-4">
                                <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Date de
                                    début:</label>
                                <input type="date" wire:model="start_date"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="start_date">
                                @error('start_date') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                            <div class="mb-4">
                                <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">Date de fin
                                    (optionnel):</label>
                                <input type="date" wire:model="end_date"
                                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    id="end_date">
                                @error('end_date') <span class="text-red-500">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="store" type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Enregistrer
                        </button>
                        <button wire:click="closeModal" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Annuler
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="mt-4 space-y-4">
        @foreach($educations as $education)
            <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                <div>
                    <h4 class="font-bold text-lg">{{ $education->school }}</h4>
                    <p class="text-gray-600">{{ $education->degree }} - {{ $education->field_of_study }}</p>
                    <p class="text-sm text-gray-500">
                        {{ $education->start_date->format('M Y') }} -
                        {{ $education->end_date ? $education->end_date->format('M Y') : 'Présent' }}
                    </p>
                </div>
                <div class="flex space-x-2">
                    <button wire:click="edit({{ $education->id }})"
                        class="text-blue-500 hover:text-blue-700">Editer</button>
                    <button wire:click="delete({{ $education->id }})" class="text-red-500 hover:text-red-700"
                        onclick="confirm('Êtes-vous sûr ?') || event.stopImmediatePropagation()">Supprimer</button>
                </div>
            </div>
        @endforeach
    </div>
</div>