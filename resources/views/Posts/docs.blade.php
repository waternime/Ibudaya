@extends('layouts.dashboard')

@section('title', 'Dokumen')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center">📄 Feed Dokumen</h2>

    @foreach($posts as $post)
        <div class="mb-10 border rounded-lg shadow bg-white">
            {{-- Header post --}}
            <div class="flex items-center justify-between px-4 py-3 border-b">
                <p class="font-semibold">{{ $post->title }}</p>
                @if($post->doc_type)
                    <span class="text-xs px-2 py-1 bg-gray-200 rounded">
                        {{ strtoupper($post->doc_type) }}
                    </span>
                @endif
            </div>

            {{-- Thumbnail / Cover (buat lebih besar, penuh lebar) --}}
            @if($post->cover_path)
                <div class="w-full bg-gray-100 flex justify-center">
                    <img src="{{ asset('storage/' . $post->cover_path) }}" 
                         alt="Cover {{ $post->title }}" 
                         class="w-full object-contain">
                </div>
            @endif

            {{-- Tombol aksi (Download kiri, Preview kanan) --}}
            <div class="flex flex-col sm:flex-row gap-2 px-4 py-3 border-b">
                {{-- Tombol Download --}}
                <a href="{{ route('posts.download', $post->id) }}" 
                   class="flex-1 text-center px-3 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                    ⬇️ Download Dokumen
                </a>

                {{-- Tombol Preview hanya untuk PDF --}}
                @if($post->doc_type === 'pdf')
                    <a href="{{ route('posts.preview', $post->id) }}" target="_blank" 
                       class="flex-1 text-center px-3 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-700">
                        🔍 Preview PDF
                    </a>
                @endif
            </div>

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
</div>
@endsection