@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto p-4">
    {{-- Header Profil --}}
    <div class="flex items-center gap-4 mb-6">
        {{-- Foto Profil --}}
        @if(Auth::user()->profile_picture)
            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" 
                 alt="Foto Profil {{ Auth::user()->name }}" 
                 class="w-16 h-16 rounded-full object-cover border">
        @else
            <div class="w-16 h-16 flex items-center justify-center bg-gray-300 rounded-full text-2xl">
                👤
            </div>
        @endif

        <div>
            <h1 class="text-3xl font-extrabold mb-1 flex items-center gap-3">
                {{ Auth::user()->name ?? 'Tamu' }}
                <a href="{{ route('profile.edit') }}" 
                   class="text-lg font-semibold text-blue-600 hover:text-blue-800 underline">
                    ✏️ Edit Profile
                </a>
            </h1>
            @if(Auth::check())
                <p class="text-gray-600">ID : ({{ Auth::user()->id }})</p>
            @endif
        </div>
    </div>

    {{-- Daftar Postingan --}}
    @if($posts->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($posts as $post)
                <div class="border rounded-lg shadow bg-white overflow-hidden">
                    @php
                        $coverPath = $post->cover_path;
                        $filePath  = $post->file_path;
                        $isImage   = $filePath && \Illuminate\Support\Str::endsWith($filePath, ['jpg','jpeg','png','gif','webp']);
                        $isMusic   = $post->category === 'music' && $filePath;
                    @endphp

                    {{-- Media Preview --}}
                    @if($coverPath)
                        <img src="{{ asset('storage/' . $coverPath) }}" 
                             alt="Cover {{ $post->title }}" 
                             class="w-full h-48 object-contain">
                    @elseif($post->category === 'images' && $isImage)
                        <img src="{{ asset('storage/' . $filePath) }}" 
                             alt="{{ $post->title }}" 
                             class="w-full h-48 object-contain">
                    @elseif($post->category === 'videos' && $filePath)
                        <div class="w-full h-48 flex flex-col justify-center items-center bg-gray-100 text-center">
                            🎬 Video
                            <video controls class="mt-2 w-full h-32 object-cover">
                                <source src="{{ asset('storage/' . $filePath) }}" type="video/mp4">
                                Browser kamu tidak mendukung video.
                            </video>
                        </div>
                    @elseif($isMusic)
                        <div class="w-full h-48 flex flex-col justify-center items-center bg-gray-100 text-center p-4">
                            🎵 Musik
                            <p class="mt-2 font-semibold">{{ $post->title }}</p>
                            <audio controls class="mt-2 w-full">
                                <source src="{{ asset('storage/' . $filePath) }}" type="audio/mpeg">
                                Browser kamu tidak mendukung audio.
                            </audio>
                        </div>
                    @elseif($filePath)
                        <div class="w-full h-48 flex flex-col justify-center items-center bg-gray-100 text-center">
                            📄 {{ strtoupper($post->doc_type ?? 'FILE') }}
                            <a href="{{ asset('storage/' . $filePath) }}" target="_blank" 
                               class="text-blue-600 hover:underline mt-2">
                                Lihat Dokumen
                            </a>
                        </div>
                    @endif

                    {{-- Konten Post --}}
                    <div class="p-4">
                        <h2 class="text-lg font-semibold mb-2">{{ $post->title }}</h2>

                        <p class="text-gray-600 text-sm mb-2">
                            Kategori: {{ ucfirst($post->category) }}
                        </p>

                        <p class="text-gray-500 text-sm mb-2">
                            ❤️ {{ $post->likes()->count() }} suka
                        </p>

                        @if(!empty($post->content))
                            <p class="text-gray-700 text-sm mb-2">
                                {{ \Illuminate\Support\Str::limit($post->content, 100) }}
                            </p>
                        @endif

                        <a href="{{ route('posts.show', $post->id) }}" 
                           class="block w-full text-center px-3 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 mt-2">
                            Lihat Selengkapnya
                        </a>

                        {{-- Tombol Edit & Hapus --}}
                        <div class="flex justify-between mt-2">
                            <a href="{{ route('posts.edit', $post->id) }}" 
                               class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">
                                ✏️ Edit
                            </a>

                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus postingan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-500">Belum ada posting.</p>
    @endif
</div>
@endsection