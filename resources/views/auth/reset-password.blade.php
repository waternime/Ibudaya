@extends('layouts.auth')

@section('content')
<div class="flex min-h-screen">
    {{-- Bagian kiri (form reset password) --}}
    <div class="w-full md:w-1/3 flex items-center justify-center bg-gray-100 p-8">
        <div class="w-full max-w-md bg-white p-8 rounded shadow">
            <h1 class="text-2xl font-bold mb-4 text-center">Reset Password</h1>
            <p class="text-gray-600 mb-6 text-center">Masukkan password baru Anda.</p>

            {{-- Status sukses --}}
            @if(session('status'))
                <div class="bg-green-100 text-green-700 p-2 rounded mb-4 text-center">
                    {{ session('status') }}
                </div>
            @endif

            {{-- Form reset password --}}
            <form method="POST" action="{{ route('password.update', ['userId' => $userId]) }}" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <input type="password" name="password" placeholder="Password Baru" required
                           class="w-full p-2 border rounded">
                    @error('password')
                        <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required
                           class="w-full p-2 border rounded">
                </div>

                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white p-2 rounded">
                    Ubah Password
                </button>
            </form>

            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Kembali ke Login</a>
            </div>
        </div>
    </div>

    {{-- Bagian kanan slideshow --}}
    <div class="hidden md:flex md:w-2/3 relative"
         x-data="{ images: [
            '{{ asset('images/banner1.jpg') }}',
            '{{ asset('images/banner2.jpg') }}',
            '{{ asset('images/banner3.jpg') }}'
         ].filter(src => src !== ''), current: 0 }"
         x-init="if(images.length > 1) setInterval(() => current = (current + 1) % images.length, 4000)">
        
        <template x-for="(src, index) in images" :key="index">
            <img :src="src"
                 class="absolute inset-0 w-full h-full object-cover transition-opacity duration-1000"
                 :class="index === current ? 'opacity-100' : 'opacity-0'">
        </template>
    </div>
</div>
@endsection