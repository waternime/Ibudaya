{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ibudaya</title>
    @vite(['resources/css/app.css', 'resources/css/menu.css', 'resources/js/app.js'])
    <link rel="icon" type="image/jpg" href="{{ asset('images/logoibudaya.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        {{-- Navigation --}}
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    {{-- Logo --}}
                    <div class="hidden md:flex items-center">
                        <a href="{{ route('posts.latest') }}">
                            <img src="{{ asset('images/logoibudaya.png') }}" alt="Ibudaya Logo" class="h-24 w-auto">
                        </a>
                    </div>

                    {{-- Navigation Links --}}
                    <div class="hidden md:flex items-center space-x-8">
                    @guest
                        <a href="{{ route('posts.latest') }}" class="text-gray-700 hover:text-amber-700 font-medium transition duration-200">
                            Komunitas
                        </a>
                        <a href="{{ route('welcome') }}" class="text-gray-700 hover:text-amber-700 font-medium transition duration-200">
                            Beranda
                        </a>
                        <a href="{{ route('aboutus') }}" class="text-gray-700 hover:text-amber-700 font-medium transition duration-200">
                            About Us
                        </a>
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-amber-700 font-medium transition duration-200">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="bg-amber-700 hover:bg-amber-800 text-white px-4 py-2 rounded-lg font-medium transition duration-200">
                            Daftar
                        </a>
                    @else
                        <a href="{{ route('dashboard') }}" class="login">Dashboard</a>
                        <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="register" style="cursor:pointer;">Logout</button>
                    </form>
                    @endguest
                    </div>

                    {{-- Mobile menu button --}}
                    <div class="md:hidden">
                        <button type="button" class="text-gray-700 hover:text-amber-700 focus:outline-none focus:text-amber-700">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        {{-- Page Content --}}
        <main>
            @yield('content')
        </main>

        {{-- Footer --}}
        <footer class="bg-gray-50 border-t border-gray-200">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <div class="text-sm text-gray-600">
                        © 2025IBUDAYA • LPPM UMN
                    </div>
                    <div class="text-sm text-gray-600">
                        Dibuat dengan cinta untuk budaya Indonesia
                    </div>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>