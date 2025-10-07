@extends('layouts.auth')

@section('content')
<div class="flex min-h-screen">
    {{-- Bagian kiri (form register) --}}
    <div class="w-full md:w-1/3 flex items-start justify-center bg-white p-8">
        <div class="w-full max-w-sm mt-10">
            {{-- Logo di atas --}}
            <img src="{{ asset('images/logo.png') }}" 
                 alt="Indonesia Culture Logo" 
                 class="w-96 h-auto mb-6">

            {{-- Judul --}}
            <h1 class="text-3xl font-bold mb-2">Buat Akun Baru</h1>
            <p class="text-gray-600 mb-6">Gabung dengan Komunitas Indonesia Culture sekarang juga.</p>

            {{-- error message --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 p-2 rounded mb-3">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <input type="text" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required
                       class="w-full px-4 py-2 border rounded">
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required
                       class="w-full px-4 py-2 border rounded">
                <input type="password" name="password" placeholder="Password" required
                       class="w-full px-4 py-2 border rounded">
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required
                       class="w-full px-4 py-2 border rounded">

                <label class="block text-sm font-medium">Tanggal Lahir</label>
                <input type="date" name="birth_date" value="{{ old('birth_date') }}" required
                       class="w-full px-4 py-2 border rounded">

                <label class="block text-sm font-medium">Gender</label>
                <select name="gender" required class="w-full px-4 py-2 border rounded">
                    <option value="">-- Pilih Gender --</option>
                    <option value="male"   @selected(old('gender')==='male')>Laki-laki</option>
                    <option value="female" @selected(old('gender')==='female')>Perempuan</option>
                </select>

                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 rounded">
                    Register
                </button>

                <div class="flex flex-col gap-2">
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Sudah punya akun? Login</a>
                    <a href="{{ route('posts.latest') }}" class="text-gray-600 hover:underline flex items-center gap-1">
                        ⬅️ <span>Kembali</span>
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Bagian kanan (slideshow max 3 gambar) --}}
    <div class="hidden md:flex md:w-2/3 relative" 
         x-data="{ images: [
            '{{ asset('images/banner1.jpg') }}',
            '{{ asset('images/banner2.jpg') }}',
            '{{ asset('images/banner3.jpg') }}'
         ].filter(src => src !== ''), current: 0 }" 
         x-init="if(images.length > 1) setInterval(() => current = (current + 1) % images.length, 4000)">

        {{-- Loop gambar --}}
        <template x-for="(src, index) in images" :key="index">
            <img :src="src" 
                 class="absolute inset-0 w-full h-full object-cover transition-opacity duration-1000"
                 :class="index === current ? 'opacity-100' : 'opacity-0'">
        </template>
    </div>
</div>
@endsection