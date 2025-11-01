@extends('layouts.dashboard')
@section('title', 'Video')

@section('content')
<div id="post-container" class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center">🎬 Feed Video</h2>

    @forelse($posts as $post)
        @if ($post->category === 'videos' && $post->file_path)
            {{-- Card Post --}}
            <div class="mb-10 border rounded-lg shadow bg-white overflow-hidden hover:shadow-lg hover:-translate-y-1 transition duration-200">

                {{-- Bungkus seluruh isi card ke link detail --}}
                <a href="{{ route('posts.show', $post->id) }}" class="block">

                    {{-- Header --}}
                    <div class="flex items-center justify-between px-4 py-3 border-b">
                        <div>
                            <p class="font-semibold">{{ $post->title ?? 'Tanpa Judul' }}</p>
                            <span class="text-xs text-gray-500 block">
                                📌 {{ ucfirst($post->province) ?? 'Umum' }}
                            </span>
                            <span class="text-xs text-gray-500">
                                🎭 {{ ucfirst($post->file_category) ?? 'Tidak ada kategori' }}
                            </span>
                        </div>
                        <span class="text-xs px-2 py-1 bg-gray-200 rounded">
                            🎬 Video
                        </span>
                    </div>

                    {{-- Video utama --}}
                    <div class="w-full bg-black flex justify-center relative overflow-hidden group rounded-b-lg">
                        <video 
                            preload="metadata" 
                            playsinline 
                            class="video-player max-h-[500px] object-contain w-full rounded-b cursor-pointer transition-transform duration-200 group-hover:scale-[1.02]" 
                            poster="{{ $post->cover_path ? asset('storage/' . $post->cover_path) : '' }}"
                            onclick="event.preventDefault(); event.stopPropagation();"
                            controlslist="nodownload"
                        >
                            <source src="{{ asset('storage/' . $post->file_path) }}" type="video/mp4">
                            Browser kamu tidak mendukung video.
                        </video>

                        {{-- Overlay ▶️ muncul sebelum video diputar, lalu hilang permanen --}}
                        <div class="video-overlay absolute inset-0 flex items-center justify-center bg-black/30 transition-opacity duration-500 opacity-0 group-hover:opacity-100 pointer-events-none">
                            <span class="text-white text-5xl">▶️</span>
                        </div>
                    </div>

                    {{-- Caption --}}
                    @if($post->description)
                        <div class="px-4 py-3 text-sm text-gray-700 border-b">
                            {{ $post->description }}
                        </div>
                    @endif
                </a>

                {{-- Like & Comment --}}
                <div class="px-4 py-3 text-lg">
                    <p class="text-gray-400 text-xs mb-2">Dibuat: {{ $post->created_at->diffForHumans() }}</p>
                    <div class="flex items-center gap-6">
                        <form action="{{ route('posts.like', $post->id) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="flex items-center gap-2 hover:text-red-600 transition-colors duration-200">
                                ❤️ <span>{{ $post->likes()->count() }}</span>
                            </button>
                        </form>
                        <a href="{{ route('posts.show', $post->id) }}" 
                           class="flex items-center gap-2 hover:text-green-600 transition-colors duration-200">
                            💬 <span>{{ $post->comments()->count() }}</span>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    @empty
        <p class="text-gray-500 text-center">Belum ada video yang diupload.</p>
    @endforelse
</div>

{{-- Loader kecil --}}
<div id="loader" class="text-center py-4 hidden text-gray-500">
    ⏳ Memuat postingan...
</div>
@endsection