<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

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
        </div>
        
        <div id="notification-container" class="fixed top-5 right-5 z-50 space-y-3"></div>
        @auth
            <script>
            document.addEventListener("DOMContentLoaded", function () {

                Echo.channel('user.{{ auth()->id() }}')
                    .listen('FriendRequestSent', (e) => {

                        showNotification(e.sender.name + " sent you a friend request!");

                    });

            });

            function showNotification(message) {

                const container = document.getElementById('notification-container');

                const notification = document.createElement('div');
                notification.className =
                    "bg-white shadow-xl border border-gray-200 rounded-lg px-4 py-3 flex items-start gap-3 animate-slide-in";

                notification.innerHTML = `
                    <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white font-bold">
                        +
                    </div>
                    <div class="text-sm font-semibold text-gray-800">
                        ${message}
                    </div>
                `;

                container.appendChild(notification);

                // Remove after 5 seconds
                setTimeout(() => {
                    notification.classList.add("opacity-0");
                    setTimeout(() => notification.remove(), 500);
                }, 5000);
            }
            </script>
        @endauth


    </body>
</html>
