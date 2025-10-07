@extends('layouts.auth')

@section('content')
<div class="min-h-screen flex items-center justify-center 
                bg-gradient-to-br from-gray-100 via-gray-200 to-gray-300 
                relative overflow-hidden">

        <!-- Background motif batik -->
        <div class="absolute inset-0 bg-[url('/images/batik-pattern.png')] 
                    bg-repeat opacity-5"></div>

        <!-- Card -->
        <div class="relative z-10 w-full max-w-md bg-white shadow-lg rounded-2xl p-8">
            
            <!-- Logo & Tagline -->
            <div class="text-center">
                <img src="{{ asset('images/logoibudaya.png') }}" 
                     class="h-32 mx-auto mb-3" 
                     alt="iBudaya Logo">
                <h2 class="text-2xl font-bold text-gray-800">Selamat Datang di iBudaya</h2>
                <p class="text-gray-500 text-sm">Platform Digital Budaya Indonesia</p>
            </div>

            {{-- pesan sukses setelah register --}}
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            {{-- error login --}}
            @if ($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email -->
                <div class="relative">
                    <input type="email" name="email" placeholder="Email" required
                           class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 
                                  focus:ring-2 focus:ring-amber-500 focus:border-amber-500 
                                  text-sm">
                    <svg class="w-5 h-5 absolute left-3 top-3.5 text-gray-400" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M16 12H8m8 0H8m4 4v-8"/>
                    </svg>
                </div>

                <!-- Password -->
                <div class="relative">
                    <input type="password" name="password" placeholder="Password" required
                           class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 
                                  focus:ring-2 focus:ring-amber-500 focus:border-amber-500 
                                  text-sm">
                    <svg class="w-5 h-5 absolute left-3 top-3.5 text-gray-400" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M12 11c0-1.105.895-2 2-2s2 .895 2 2-2 2-2 2zm0 0c0-1.105-.895-2-2-2s-2 .895-2 2 2 2 2 2z"/>
                    </svg>
                </div>

                <!-- Tombol Login -->
                <button type="submit" 
                        class="w-full bg-amber-600 text-white py-3 rounded-lg font-semibold 
                               hover:bg-amber-700 hover:scale-[1.02] transition-all">
                    Login
                </button>

                <!-- Divider -->
                <div class="flex items-center my-2">
                    <hr class="flex-grow border-gray-300">
                    <span class="px-2 text-gray-500 text-sm">atau</span>
                    <hr class="flex-grow border-gray-300">
                </div>

                <!-- Register -->
                <a href="{{ route('register') }}" 
                   class="block w-full text-center bg-amber-100 text-amber-700 py-3 
                          rounded-lg font-medium hover:bg-amber-200 transition">
                    Buat Akun Baru
                </a>

                <!-- Kembali -->
                <a href="{{ url('/') }}" 
                   class="block w-full text-center bg-green-500 text-white py-3 
                          rounded-lg font-medium hover:bg-green-600 transition">
                    Kembali ke Halaman Utama
                </a>
            </form>
        </div>
    </section>
</div>
@endsection