@extends('layouts.dashboard')

@section('title', 'Edit Profile')

@section('content')
<div class="container mx-auto p-4 max-w-md">
    <h1 class="text-2xl font-bold mb-4">Edit Profile</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Foto Profil --}}
        <label class="block mb-2 text-gray-700">Foto Profil</label>
        <div class="flex items-center gap-4 mb-4">
            @if($user->profile_picture)
                <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                     alt="Foto Profil" 
                     class="w-16 h-16 rounded-full object-cover border">
            @else
                <div class="w-16 h-16 flex items-center justify-center bg-gray-300 rounded-full text-2xl">
                    👤
                </div>
            @endif
            <input type="file" name="profile_picture" class="w-full border p-2 rounded">
        </div>

        @error('profile_picture')
            <div class="text-red-600 mb-2">{{ $message }}</div>
        @enderror

        {{-- Nama --}}
        <label class="block mb-2 text-gray-700">Nama Pengguna</label>
        <input type="text" name="name" value="{{ old('name', $user->name) }}" 
               class="w-full p-2 border rounded mb-4" required>

        @error('name')
            <div class="text-red-600 mb-2">{{ $message }}</div>
        @enderror

        {{-- Password --}}
        <label class="block mb-2 text-gray-700">Password Baru (opsional)</label>
        <input type="password" name="password" class="w-full p-2 border rounded mb-2">

        <label class="block mb-2 text-gray-700">Konfirmasi Password</label>
        <input type="password" name="password_confirmation" class="w-full p-2 border rounded mb-4">

        @error('password')
            <div class="text-red-600 mb-2">{{ $message }}</div>
        @enderror

        <button type="submit" 
                class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">
            Simpan
        </button>
    </form>
</div>
@endsection