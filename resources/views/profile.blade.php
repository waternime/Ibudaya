@extends('layouts.dashboard')

@section('title', 'Profile')

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
            </h1>
            <a href="{{ route('profile.edit') }}" 
                   class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">
                    ✏️ Edit Profile
                </a>
            @if(Auth::check())
                <p class="text-gray-600">ID : ({{ Auth::user()->id }})</p>
            @endif
        </div>
    </div>

    {{-- Filter Kategori --}}
    <div class="mb-6 flex flex-wrap gap-2 justify-start">
        <button class="filter-btn px-4 py-2 rounded-full bg-red-600 text-white hover:bg-red-700 transition-all" data-filter="all">Semua</button>
        <button class="filter-btn px-4 py-2 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition-all" data-filter="images">Gambar</button>
        <button class="filter-btn px-4 py-2 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition-all" data-filter="music">Musik</button>
        <button class="filter-btn px-4 py-2 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition-all" data-filter="videos">Video</button>
        <button class="filter-btn px-4 py-2 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 transition-all" data-filter="docs">Dokumen</button>
    </div>

    {{-- Daftar Postingan --}}
@if($posts->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($posts as $post)
            <div class="post-item border rounded-lg shadow bg-white dark:bg-gray-800 dark:text-white overflow-hidden transition"
                 data-category="{{ $post->category }}"> {{-- penting! --}}
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
                    <div class="w-full h-48 flex flex-col justify-center items-center bg-gray-100 dark:bg-gray-700 text-center">
                        🎬 Video
                        <video controls class="mt-2 w-full h-32 object-cover">
                            <source src="{{ asset('storage/' . $filePath) }}" type="video/mp4">
                            Browser kamu tidak mendukung video.
                        </video>
                    </div>
                @elseif($isMusic)
                    <div class="w-full h-48 flex flex-col justify-center items-center bg-gray-100 dark:bg-gray-700 text-center p-4">
                        🎵 Musik
                        <p class="mt-2 font-semibold text-gray-900 dark:text-white">{{ $post->title }}</p>
                        <audio controls class="mt-2 w-full">
                            <source src="{{ asset('storage/' . $filePath) }}" type="audio/mpeg">
                            Browser kamu tidak mendukung audio.
                        </audio>
                    </div>
                @elseif($filePath)
                    <div class="w-full h-48 flex flex-col justify-center items-center bg-gray-100 dark:bg-gray-700 text-center">
                        📄 {{ strtoupper($post->doc_type ?? 'FILE') }}
                        <a href="{{ asset('storage/' . $filePath) }}" target="_blank" 
                           class="text-red-600 hover:underline mt-2">
                            Lihat Dokumen
                        </a>
                    </div>
                @endif

                {{-- Konten Post --}}
                <div class="p-4">
                    <h2 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white">{{ $post->title }}</h2>
                    <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">Kategori: {{ ucfirst($post->category) }}</p>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mb-2">❤️ {{ $post->likes()->count() }} suka</p>

                    @if(!empty($post->content))
                        <p class="text-gray-700 dark:text-gray-300 text-sm mb-2">
                            {{ \Illuminate\Support\Str::limit($post->content, 100) }}
                        </p>
                    @endif

                    <a href="{{ route('posts.show', $post->id) }}" 
                       class="block w-full text-center px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700 mt-2">
                        Lihat Selengkapnya
                    </a>

                    <div class="flex justify-between mt-2">
                        <a href="{{ route('posts.edit', $post->id) }}" 
                           class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">
                            ✏️ Edit
                        </a>

                        <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus postingan ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">
                                🗑️ Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p class="text-gray-500 dark:text-gray-400">Belum ada posting.</p>
@endif

{{-- Script Filter --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const buttons = document.querySelectorAll('.filter-btn');
    const posts = document.querySelectorAll('.post-item');

    // pastikan tombol "Semua" aktif saat load
    buttons.forEach(b => {
        if(b.getAttribute('data-filter') === 'all') {
            b.classList.add('bg-red-600', 'text-white');
            b.classList.remove('bg-gray-200', 'text-gray-700');
        }
    });

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            const filter = btn.getAttribute('data-filter');

            // reset semua tombol
            buttons.forEach(b => {
                b.classList.remove('bg-red-600', 'text-white');
                b.classList.add('bg-gray-200', 'text-gray-700');
            });

            // set tombol aktif
            btn.classList.add('bg-red-600', 'text-white');
            btn.classList.remove('bg-gray-200', 'text-gray-700');

            // tampilkan/sembunyikan postingan
            posts.forEach(post => {
                if (filter === 'all' || post.dataset.category === filter) {
                    post.classList.remove('hidden');
                } else {
                    post.classList.add('hidden');
                }
            });
        });
    });
});
</script>
@endsection