@extends('layouts.dashboard')

@section('title', 'Hasil Pencarian')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center">
        🔍 Hasil Pencarian: "{{ request('search') }}"
    </h2>

    @if($posts->count())
        @foreach($posts as $post)
            <div class="mb-10 border rounded-lg shadow bg-white overflow-hidden">

                {{-- Header post --}}
                <div class="flex items-center justify-between px-4 py-3 border-b">
                    <p class="font-semibold">{{ $post->title }}</p>
                    <span class="text-xs px-2 py-1 bg-gray-200 rounded">
                        {{ ucfirst($post->category) }}
                    </span>
                </div>

                {{-- Media / Konten --}}
                @php
                    $coverPath = $post->cover_path;
                    $filePath  = $post->file_path;
                    $isImage   = $filePath && \Illuminate\Support\Str::endsWith($filePath, ['jpg','jpeg','png','gif','webp']);
                    $isMusic   = $filePath && \Illuminate\Support\Str::endsWith($filePath, ['mp3','wav','ogg']);
                    $isVideo   = $filePath && \Illuminate\Support\Str::endsWith($filePath, ['mp4','webm']);
                    $isDoc     = $filePath && \Illuminate\Support\Str::endsWith($filePath, ['pdf','doc','docx','xls','xlsx','ppt','pptx']);
                @endphp

                {{-- Cover hanya tampil kalau bukan video --}}
                @if ($coverPath && !$isVideo)
                    <div class="w-full bg-gray-100">
                        <img src="{{ asset('storage/' . $coverPath) }}" 
                             alt="Cover {{ $post->title }}" 
                             class="w-full object-contain">
                    </div>
                @endif

                {{-- File gambar --}}
                @if ($isImage)
                    <div class="w-full bg-gray-100">
                        <img src="{{ asset('storage/' . $filePath) }}" 
                             alt="{{ $post->title }}" 
                             class="w-full object-contain">
                    </div>
                @endif

                {{-- Musik --}}
                @if ($isMusic)
                    <div class="px-4 py-3 border-b">
                        <button 
                            class="music-track w-full text-center px-3 py-2 bg-purple-600 text-white text-sm rounded hover:bg-purple-700"
                            data-src="{{ asset('storage/' . $filePath) }}"
                            data-title="{{ $post->title }}">
                            🎵 Putar Musik
                        </button>
                    </div>
                @endif

                {{-- Video --}}
                @if ($isVideo)
                    <div class="w-full bg-black border-b">
                        <video controls class="w-full" style="max-height:400px;">
                            <source src="{{ asset('storage/' . $filePath) }}" type="video/mp4">
                            Browser Anda tidak mendukung pemutar video.
                        </video>
                    </div>
                @endif

                {{-- Dokumen --}}
                @if ($isDoc && $post->category === 'docs')
                    <div class="px-4 py-3 border-b flex gap-3">
                        {{-- Download --}}
                        <a href="{{ route('posts.download', $post->id) }}"
                           class="flex-1 text-center px-3 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700">
                            ⬇️ Download Dokumen
                        </a>

                        {{-- Preview PDF --}}
                        @if (\Illuminate\Support\Str::endsWith($filePath, 'pdf'))
                            <a href="{{ route('posts.preview', $post->id) }}" target="_blank"
                               class="flex-1 text-center px-3 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-700">
                                🔍 Preview
                            </a>
                        @endif
                    </div>
                @endif

                {{-- Konten singkat --}}
                @if($post->content)
                    <div class="px-4 py-3 text-sm text-gray-700 border-b">
                        {{ Str::limit($post->content, 200) }}
                    </div>
                @endif

                {{-- Aksi --}}
                <div class="px-4 py-3 text-lg">
                    <p class="text-gray-400 text-xs mb-2">
                        Dibuat: {{ $post->created_at->diffForHumans() }}
                    </p>

                    <div class="flex items-center gap-6">
                        {{-- Like --}}
                        <form action="{{ route('posts.like', $post->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 hover:text-red-600">
                                ❤️ <span>{{ $post->likes()->count() }}</span>
                            </button>
                        </form>

                        {{-- Komentar hanya untuk non-music --}}
                        @if ($post->category !== 'music')
                            <a href="{{ route('posts.show', $post->id) }}" class="flex items-center gap-2 hover:text-green-600">
                                💬 <span>{{ $post->comments()->count() }}</span>
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        @endforeach

        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    @else
        <p class="text-gray-500 text-center">Tidak ada hasil untuk pencarian ini.</p>
    @endif
</div>
@endsection