<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-red-50 to-pink-100 px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 text-center">
        
        <!-- Icon -->
        <div class="flex justify-center mb-6">
            <div class="h-24 w-24 rounded-full bg-red-100 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h2 class="text-3xl font-extrabold text-gray-800 mb-4">
            Transaction annulée
        </h2>

        <!-- Message -->
        <p class="text-gray-600 mb-8 text-lg">
            Votre paiement n'a pas pu être complété.
        </p>

        <!-- Buttons -->
        <div class="space-y-4">
            <a href="dashboard"
                class="block w-full bg-gradient-to-r from-blue-600 to-indigo-600
                       text-white py-3 rounded-xl font-semibold text-lg
                       hover:opacity-90 transition shadow-lg"
            >
                Retour au tableau de bord
            </a>
            
            <a href="{{ route('pricing') }}"
                class="block w-full bg-gray-100 text-gray-700 py-3 rounded-xl font-semibold text-lg
                       hover:bg-gray-200 transition"
            >
                Voir nos offres
            </a>
        </div>

    </div>
</div>
