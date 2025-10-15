@extends('layouts.dashboard')
@section('title', 'Video')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center">🎬 Video</h2>

    @if ($posts->count() > 0)
        @foreach ($posts as $post)
            @if ($post->category === 'videos' && $post->file_path)
                <div class="mb-10 border rounded-lg shadow bg-white overflow-hidden">
                    {{-- Header Post --}}
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

                    {{-- Menampilkan Video --}}
                    <div class="w-full bg-black flex justify-center">
                        <video controls class="max-h-[500px] object-contain w-full">
                            <source src="{{ asset('storage/' . $post->file_path) }}" type="video/mp4">
                            Browser kamu tidak mendukung video.
                        </video>
                    </div>

                    {{-- Thumbnail / Cover disembunyikan --}}
                    @if ($post->cover_path)
                        <div class="text-center hidden" id="thumbnail-{{ $post->id }}">
                            <img src="{{ asset('storage/' . $post->cover_path) }}" 
                                 alt="Cover Video {{ $post->title }}" 
                                 class="max-h-[500px] object-contain w-full mt-2">
                        </div>
                    @endif

                    {{-- Like & Comment --}}
                    <div class="px-4 py-3 text-lg">
                        <p class="text-gray-400 text-xs mb-2">Dibuat: {{ $post->created_at->diffForHumans() }}</p>
                        <div class="flex items-center gap-6">
                            <form action="{{ route('posts.like', $post->id) }}" method="POST">@csrf
                                <button type="submit" class="flex items-center gap-2 hover:text-red-600">❤️ <span>{{ $post->likes()->count() }}</span></button>
                            </form>
                            <a href="{{ route('posts.show', $post->id) }}" class="flex items-center gap-2 hover:text-green-600 transition-colors duration-200">
                            💬 <span>{{ $post->comments()->count() }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <p class="text-gray-600 text-center">Belum ada video yang diupload.</p>
    @endif
</div>
@endsection