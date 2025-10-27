@extends('layouts.dashboard')

@section('title', 'Musik')

@section('content')
<div id="post-container" class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">🎵 Daftar Postingan Musik</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($posts as $post)
            <div class="music-track p-4 border rounded-lg hover:bg-gray-100 cursor-pointer"
                 data-src="{{ asset('storage/' . $post->file_path) }}"
                 data-title="{{ $post->title }}">
                <h3 class="font-semibold text-lg">{{ $post->title }}</h3>
                <p class="text-gray-500 text-sm mt-1">Klik untuk memutar</p>
            </div>
        @endforeach
    </div>

    {{-- Loader kecil --}}
    <div id="loader" class="text-center py-4 hidden text-gray-500">
        ⏳ Memuat postingan...
    </div>
</div>
@endsection