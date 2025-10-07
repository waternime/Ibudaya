@extends('layouts.dashboard')

@section('title', 'Posting Gambar')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center">🖼️ Feed Gambar</h2>

    @foreach($posts as $post)
        <div class="mb-10 border rounded-lg shadow bg-white">
            {{-- Header post --}}
            <div class="flex items-center justify-between px-4 py-3 border-b">
                <p class="font-semibold">{{ $post->title ?? 'Tanpa Judul' }}</p>
                <span class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</span>
            </div>

            {{-- Gambar utama --}}
            <div class="w-full bg-black flex justify-center">
                <img src="{{ asset('storage/' . $post->file_path) }}" 
                     alt="{{ $post->title }}" 
                     class="max-h-[500px] object-contain w-full">
            </div>

            {{-- Caption (opsional) --}}
            @if($post->description)
                <div class="px-4 py-3 text-sm text-gray-700 border-b">
                    {{ $post->description }}
                </div>
            @endif

            {{-- Like & Komentar --}}
            <div class="flex items-center gap-6 px-4 py-3 text-lg">
                <form action="{{ route('posts.like', $post->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center gap-2 hover:text-red-600">
                        ❤️ <span>{{ $post->likes()->count() }}</span>
                    </button>
                </form>

                <a href="{{ route('posts.show', $post->id) }}" class="flex items-center gap-2 hover:text-green-600">
                    💬 <span>{{ $post->comments()->count() }}</span>
                </a>
            </div>
        </div>
    @endforeach

    @if($posts->isEmpty())
        <p class="text-muted text-center">Belum ada postingan gambar.</p>
    @endif
</div>
@endsection