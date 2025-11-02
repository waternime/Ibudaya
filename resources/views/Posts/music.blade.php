@extends('layouts.dashboard')

@section('title', 'Musik')

@section('content')
<div id="post-container" class="container mx-auto p-4">
    <h2 class="text-2xl font-bold mb-4">🎵 Daftar Postingan Musik</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($posts as $post)
            <div class="music-track p-4 border rounded-lg hover:bg-gray-100 cursor-pointer flex flex-col justify-between"
                 data-src="{{ asset('storage/' . $post->file_path) }}"
                 data-title="{{ $post->title }}">
                 
                <div class="track-info">
                    <h3>{{ $post->title }}</h3>
                    <p>Klik untuk memutar</p>
                </div>
                <div class="mt-3 flex justify-between">
                    <form action="{{ route('posts.like', $post->id) }}" method="POST" class="flex items-center gap-1">
                        @csrf
                        <button type="submit" class="like-btn">❤️ {{ $post->likes()->count() }}</button>
                    </form>
                    <a href="{{ route('posts.show', $post->id) }}" class="comment-link">💬 {{ $post->comments()->count() }}</a>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Loader kecil --}}
    <div id="loader" class="text-center py-4 hidden text-gray-500">
        ⏳ Memuat postingan...
    </div>
</div>
@endsection