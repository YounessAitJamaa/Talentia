<x-guest-layout>

    <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">
        Choisissez votre profil
    </h2>

    <form action="{{ route('setRole') }}" method="POST">
        @csrf

        <div class="space-y-4 mb-6">

            <label class="flex items-start gap-3 p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                <input type="radio" name="role" value="chercheur" required class="mt-1 text-blue-600">
                <div>
                    <p class="font-semibold text-gray-800">Chercheur</p>
                    <p class="text-sm text-gray-500">
                        Je cherche un emploi ou des missions.
                    </p>
                </div>
            </label>

            <label class="flex items-start gap-3 p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                <input type="radio" name="role" value="recruteur" class="mt-1 text-blue-600">
                <div>
                    <p class="font-semibold text-gray-800">Recruteur</p>
                    <p class="text-sm text-gray-500">
                        Je souhaite publier des offres et recruter.
                    </p>
                </div>
            </label>

        </div>

        <button
            type="submit"
            class="w-full bg-blue-600 text-white py-2.5 rounded-lg font-semibold hover:bg-blue-700 transition">
            Confirmer mon choix
        </button>

    </form>

</x-guest-layout>
