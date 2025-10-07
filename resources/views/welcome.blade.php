{{-- resources/views/home.blade.php --}}
@extends('layouts.auth')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-100 via-gray-200 to-gray-300">
    {{-- Hero Section --}}
    <div class="relative min-h-screen flex items-center">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                
                {{-- Left Content --}}
                <div class="space-y-8">
                    {{-- Logo and Brand --}}
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-amber-700 rounded-lg flex items-center justify-center">
                            <span class="text-white font-bold text-lg">IB</span>
                        </div>
                        <div>
                            <div class="text-xl font-bold text-gray-900">IBUDAYA</div>
                            <div class="text-sm text-gray-600 tracking-wide">BUDAYA INDONESIA</div>
                        </div>
                    </div>

                    {{-- Main Headline --}}
                    <div class="space-y-6">
                        <h1 class="text-5xl lg:text-6xl font-bold text-gray-900 leading-tight">
                            Menghidupkan<br>
                            Warisan<br>
                            <span class="text-amber-700">Nusantara</span>
                        </h1>
                        
                        <p class="text-lg text-gray-600 max-w-lg leading-relaxed">
                            IBUDAYA adalah ruang digital untuk menjelajahi, 
                            melestarikan, dan merayakan kekayaan budaya Indonesia. 
                            Bergabung untuk ikut menjaga batik, tarian, musik, bahasa 
                            daerah, dan cerita rakyat kita.
                        </p>
                    </div>

                    {{-- CTA Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}" 
                           class="inline-flex items-center justify-center px-8 py-4 bg-amber-700 hover:bg-amber-800 text-white font-semibold rounded-lg transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            Mulai Bergabung
                        </a>
                        <a href="{{ route('login') }}" 
                           class="inline-flex items-center justify-center px-8 py-4 border-2 border-gray-300 hover:border-amber-700 text-gray-700 hover:text-amber-700 font-semibold rounded-lg transition-all duration-200 bg-white hover:bg-amber-50">
                            Saya sudah punya akun
                        </a>
                    </div>
                </div>

                {{-- Right Content - Image Area --}}
                <div class="relative">
                    {{-- Placeholder for cultural imagery --}}
                    <div class="aspect-square bg-gradient-to-br from-amber-200 via-orange-200 to-amber-300 rounded-3xl shadow-2xl relative overflow-hidden">
                        
                        {{-- Decorative elements --}}
                        <div class="absolute inset-0 bg-gradient-to-tr from-amber-700/20 to-transparent"></div>
                        
                        {{-- Batik-inspired pattern overlay --}}
                        <div class="absolute inset-0 opacity-30">
                            <svg viewBox="0 0 400 400" class="w-full h-full">
                                <defs>
                                    <pattern id="batik-pattern" x="0" y="0" width="40" height="40" patternUnits="userSpaceOnUse">
                                        <circle cx="20" cy="20" r="3" fill="#92400e" opacity="0.3"/>
                                        <path d="M10,10 Q20,15 30,10 Q25,20 30,30 Q20,25 10,30 Q15,20 10,10" fill="none" stroke="#92400e" stroke-width="1" opacity="0.2"/>
                                    </pattern>
                                </defs>
                                <rect width="100%" height="100%" fill="url(#batik-pattern)"/>
                            </svg>
                        </div>

                        {{-- Central content area --}}
                        <div class="absolute inset-0 flex items-center justify-center mb-24">
                            {{-- Icon and Text --}}
                            <div class="text-center text-amber-900">
                                <div class="w-24 h-24 mx-auto mb-4 bg-amber-800 rounded-full flex items-center justify-center shadow-lg">
                                    <svg class="w-12 h-12 text-amber-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold mb-2">Warisan Budaya</h3>
                                <p class="text-sm opacity-75">Nusantara</p>
                            </div>
                        </div>
                    </div>

                    {{-- Quote Card --}}
                    <div class="absolute -bottom-8 -right-4 lg:bottom-12 lg:right-8 pr-16">
                        <div class="bg-white rounded-2xl shadow-xl p-6 max-w-sm transform rotate-2 hover:rotate-0 transition-transform duration-300">
                            <div class="flex items-start space-x-3">
                                <div class="w-2 h-16 bg-amber-700 rounded-full flex-shrink-0"></div>
                                <div>
                                    <p class="text-gray-700 text-sm leading-relaxed italic mb-3">
                                        "Terinspirasi motif batik parang dan mega mendung, IBUDAYA 
                                        menghadirkan pengalaman modern yang tetap hangat dan 
                                        akrab dengan identitas Indonesia."
                                    </p>
                                    <div class="text-xs text-gray-500">
                                        — Tim LPPM 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Background decorative elements --}}
        <div class="absolute top-20 left-10 w-32 h-32 bg-amber-200 rounded-full opacity-20 blur-3xl"></div>
        <div class="absolute bottom-32 right-20 w-48 h-48 bg-orange-300 rounded-full opacity-20 blur-3xl"></div>
    </div>

    {{-- Features Preview Section --}}
    <div class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    Jelajahi Kekayaan Budaya Indonesia
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Dari Sabang sampai Merauke, temukan dan lestarikan warisan budaya yang tak ternilai
                </p>
            </div>

            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                {{-- Batik --}}
                <div class="group text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-amber-400 to-amber-600 rounded-2xl mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zM21 5a2 2 0 00-2-2h-4a2 2 0 00-2 2v12a4 4 0 004 4h4a2 2 0 002-2V5z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Batik</h3>
                    <p class="text-gray-600">Motif dan filosofi batik dari seluruh Nusantara</p>
                </div>

                {{-- Tarian --}}
                <div class="group text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-pink-400 to-red-600 rounded-2xl mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Tarian</h3>
                    <p class="text-gray-600">Gerakan dan makna tari tradisional Indonesia</p>
                </div>

                {{-- Musik --}}
                <div class="group text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-400 to-indigo-600 rounded-2xl mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Musik</h3>
                    <p class="text-gray-600">Alat musik dan lagu daerah yang mengharukan</p>
                </div>

                {{-- Kuliner --}}
                <div class="group text-center">
                    <div class="w-20 h-20 bg-gradient-to-br from-green-400 to-emerald-600 rounded-2xl mx-auto mb-4 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Kuliner</h3>
                    <p class="text-gray-600">Cita rasa dan cerita di balik masakan tradisional</p>
                </div>
            </div>

            {{-- CTA Section --}}
            <div class="text-center mt-16">
                <a href="{{ route('aboutus') }}" 
                   class="inline-flex items-center text-amber-700 hover:text-amber-800 font-semibold text-lg group">
                    Pelajari lebih lanjut tentang IBUDAYA
                    <svg class="ml-2 w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection