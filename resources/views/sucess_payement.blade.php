<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Payment Successful
        </h2>
    </x-slot>

    <div class="min-h-[70vh] flex items-center justify-center px-4">
        <div class="bg-white shadow-xl rounded-2xl p-10 text-center max-w-md w-full">

            <!-- Icon -->
            <div class="flex justify-center">
                <div class="bg-green-100 p-4 rounded-full">
                    <svg class="w-14 h-14 text-green-600"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="3"
                         viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M5 13l4 4L19 7" />
                    </svg>
                </div>
            </div>

            <!-- Message -->
            <h1 class="text-2xl font-bold text-gray-800 mt-6">
                Payment Completed
            </h1>

            <p class="text-gray-600 mt-3">
                Your transaction was successful. You may now continue.
            </p>

            <!-- Return Button -->
            <div class="mt-8">
                <a href="{{ route('dashboard') }}"
                   class="inline-block w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition">
                    Return to Dashboard
                </a>
            </div>

        </div>
    </div>
</x-app-layout>