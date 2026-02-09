<div class="max-w-md mx-auto mt-10 p-6 bg-white shadow-lg rounded-lg">
    <h2 class="text-2xl font-bold mb-6 text-center">Choisissez votre profil</h2>

    <form action="{{ route('setRole') }}" method="POST">
        @csrf

        <div class="grid grid-cols-1 gap-4 mb-6">
            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-blue-50 transition">
                <input type="radio" name="role" value="chercheur" class="h-4 w-4 text-blue-600" required>
                <div class="ml-4">
                    <span class="block font-semibold">Chercheur</span>
                    <span class="text-sm text-gray-500">Je cherche un emploi ou des missions.</span>
                </div>
            </label>

            <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:bg-blue-50 transition">
                <input type="radio" name="role" value="recruteur" class="h-4 w-4 text-blue-600">
                <div class="ml-4">
                    <span class="block font-semibold">Recruteur</span>
                    <span class="text-sm text-gray-500">Je souhaite publier des offres et recruter.</span>
                </div>
            </label>
        </div>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg font-bold hover:bg-blue-700">
            Confirmer mon choix
        </button>
    </form>
</div>
