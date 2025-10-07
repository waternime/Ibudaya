@extends('layouts.auth')

@section('content')
<div class="flex min-h-screen">
    {{-- Bagian kiri (form forgot/reset password) --}}
    <div class="w-full md:w-1/3 flex items-center justify-center bg-white p-8">
        <div class="w-full max-w-md">
            <h1 class="text-2xl font-bold mb-4">
                {{ empty($showPasswordForm) ? 'Lupa Password' : 'Reset Password' }}
            </h1>

            {{-- Pesan status --}}
            @if(session('status'))
                <div class="bg-green-100 text-green-700 p-2 rounded mb-3">{{ session('status') }}</div>
            @endif

            {{-- Form Email --}}
            @if(empty($showPasswordForm))
                <form method="POST" action="{{ route('password.forgot') }}" class="space-y-4">
                    @csrf
                    <div>
                        <input type="email" name="email" placeholder="Email Anda" required
                               class="w-full px-4 py-2 border rounded" value="{{ old('email') }}">
                        @error('email')
                            <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded">
                        Lanjut
                    </button>
                </form>
            @else
                {{-- Form Ganti Password --}}
                <form method="POST" action="{{ route('password.forgot') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <div>
                        <input type="password" name="password" placeholder="Password Baru" required
                               class="w-full px-4 py-2 border rounded">
                        @error('password')
                            <div class="text-red-600 mt-1 text-sm">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required
                               class="w-full px-4 py-2 border rounded">
                    </div>
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded">
                        Ubah Password
                    </button>
                </form>
            @endif
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