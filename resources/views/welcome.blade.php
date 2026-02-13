<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Talentia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="bg-white shadow-md px-8 py-4 flex justify-between items-center">
        <h1 class="text-2xl font-bold text-indigo-600">Talentia</h1>
        <div class="space-x-4">
            @auth
                <a href="/dashboard" class="text-gray-700 hover:text-indigo-600">Dashboard</a>
                <form action="/logout" method="POST" class="inline">
                    @csrf
                    <button class="text-red-500 hover:text-red-700">Logout</button>
                </form>
            @else
                <a href="/login" class="text-gray-700 hover:text-indigo-600">Login</a>
                <a href="/register" class="bg-indigo-600 text-white px-4 py-2 rounded-lg hover:bg-indigo-700">
                    Register
                </a>
            @endauth
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="flex-1 flex items-center justify-center px-6">
        <div class="text-center max-w-2xl">
            <h2 class="text-4xl font-bold text-gray-800 mb-6">
                Connect With People Instantly 🚀
            </h2>

            <p class="text-gray-600 text-lg mb-8">
                Send friend requests, chat in real-time, and receive notifications instantly without refreshing the page.
            </p>

            @auth
                <a href="/users"
                   class="bg-indigo-600 text-white px-6 py-3 rounded-lg text-lg hover:bg-indigo-700">
                    Find Friends
                </a>
            @else
                <a href="/register"
                   class="bg-indigo-600 text-white px-6 py-3 rounded-lg text-lg hover:bg-indigo-700">
                    Get Started
                </a>
            @endauth
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-white text-center py-4 text-gray-500 text-sm shadow-inner">
        © {{ date('Y') }} Talentia. All rights reserved.
    </footer>

</body>
</html>
