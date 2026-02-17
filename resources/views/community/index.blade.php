<x-app-layout>
    <div class="min-h-screen bg-slate-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6 space-y-4">

            {{-- Page header --}}
            <div class="bg-white border border-slate-200 rounded-lg p-4">
                <h1 class="text-lg font-extrabold text-slate-900">Communauté</h1>
                <p class="text-sm text-slate-600">Recherchez des membres et connectez-vous.</p>
            </div>

            {{-- Search & Users --}}
            <div>
                @livewire('community-search')
            </div>

        </div>
    </div>
</x-app-layout>
