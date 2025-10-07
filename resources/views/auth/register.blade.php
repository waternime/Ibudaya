@extends('layouts.auth')

@section('content')
<!-- resources/views/auth/register.blade.php -->

    <div class="min-h-screen flex items-center justify-center 
                bg-gradient-to-br from-gray-100 via-gray-200 to-gray-300
                relative overflow-hidden pt-10 pb-10">

        <!-- Background motif batik -->

        <!-- Card -->
        <div class="relative z-10 w-full max-w-md bg-white shadow-lg rounded-2xl p-8">
            
            <!-- Logo & Tagline -->
            <div class="text-center mb-6">
                <img src="{{ asset('images/logoibudaya.png') }}" 
                     class="h-32 mx-auto" 
                     alt="iBudaya Logo">
                <h2 class="text-2xl font-bold text-gray-800">Buat Akun Baru</h2>
                <p class="text-gray-500 text-sm">Gabung bersama iBudaya dan lestarikan budaya Indonesia</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                {{-- error message --}}
                @if ($errors->any())
                    <div class="alert alert-error">
                        <ul>
                            @foreach ($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <!-- Nama -->
                <div class="relative">
                    <input type="text" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required
                           class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 
                                  focus:ring-2 focus:ring-amber-500 focus:border-amber-500 
                                  text-sm">
                    <svg class="w-5 h-5 absolute left-3 top-3.5 text-gray-400" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M5.121 17.804A8 8 0 1118.88 6.196M12 12v.01"/>
                    </svg>
                </div>

                <!-- Email -->
                <div class="relative">
                    <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required
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

                <!-- Konfirmasi Password -->
                <div class="relative">
                    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required
                           class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 
                                  focus:ring-2 focus:ring-amber-500 focus:border-amber-500 
                                  text-sm">
                    <svg class="w-5 h-5 absolute left-3 top-3.5 text-gray-400" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M5 13l4 4L19 7"/>
                    </svg>
                </div>

                <!-- Tanggal Lahir= -->
                <div class="relative">
                    <input type="date" name="birth_date" placeholder="Tanggal Lahir" value="{{ old('birth_date') }}" required
                           class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 
                                  focus:ring-2 focus:ring-amber-500 focus:border-amber-500 
                                  text-sm">
                    <svg class="w-5 h-5 absolute left-3 top-3.5 text-gray-400" 
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>

                </div>
                
                <!-- Gender -->
                <div class="relative">
                    <select name="gender" required class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 
                                  focus:ring-2 focus:ring-amber-500 focus:border-amber-500 
                                  text-sm">
                        <option value="">-- Pilih Gender --</option>
                        <option value="male"   @selected(old('gender')==='male')>Laki-laki</option>
                        <option value="female" @selected(old('gender')==='female')>Perempuan</option>
                    </select>
                    <svg class="w-5 h-5 absolute left-3 top-3.5 text-gray-400" 
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M19 5l-4 0M19 5l0 4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>

                </div>


                <!-- Tombol Register -->
                <button type="submit" 
                        class="w-full bg-amber-600 text-white py-3 rounded-lg font-semibold 
                               hover:bg-amber-700 hover:scale-[1.02] transition-all">
                    Daftar
                </button>

                <!-- Divider -->
                <div class="flex items-center my-2">
                    <hr class="flex-grow border-gray-300">
                    <span class="px-2 text-gray-500 text-sm">atau</span>
                    <hr class="flex-grow border-gray-300">
                </div>

                <!-- Sudah punya akun? -->
                <a href="{{ route('login') }}" 
                   class="block w-full text-center bg-amber-100 text-amber-700 py-3 
                          rounded-lg font-medium hover:bg-amber-200 transition">
                    Sudah punya akun? Login
                </a>

                <!-- Kembali -->
                <a href="{{ url('/') }}" 
                   class="block w-full text-center bg-green-500 text-white py-3 
                          rounded-lg font-medium hover:bg-green-600 transition">
                    Kembali ke Halaman Utama
                </a>
            </form>
        </div>
    </div>

@endsection