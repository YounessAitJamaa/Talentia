<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user-id" content="{{ auth()->id() }}">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <style>
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .animate-slide-in {
            animation: slideIn 0.3s ease-out;
            transition: opacity 0.5s ease;
        }
    </style>

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        @include('layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        {{-- Flash message popup --}}
        @if (session('status'))
            <div id="flash-status"
                 class="fixed top-5 right-5 z-50 bg-white shadow-xl border border-green-200 rounded-lg px-5 py-3 flex items-center gap-3 animate-slide-in"
                 style="max-width: 360px;">
                <div class="w-8 h-8 rounded-full bg-green-500 flex items-center justify-center text-white font-bold shrink-0">
                    ✓
                </div>
                <div class="text-sm font-semibold text-gray-800">
                    {{ session('status') }}
                </div>
            </div>
            <script>
                setTimeout(() => {
                    const el = document.getElementById('flash-status');
                    if (el) {
                        el.style.opacity = '0';
                        setTimeout(() => el.remove(), 500);
                    }
                }, 4000);
            </script>
        @endif

        <div id="notification-container" class="fixed top-5 right-5 z-50 space-y-3"></div>


    </div>
</body>

</html>