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
                 loading="lazy"
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
        @php
            $filter = request('filter', 'all');
        @endphp
        @foreach ([
            'all' => 'Semua',
            'images' => 'Gambar',
            'music' => 'Musik',
            'videos' => 'Video',
            'docs' => 'Dokumen',
        ] as $key => $label)
            <a href="{{ route('profile', ['filter' => $key]) }}"
                class="filter-btn px-4 py-2 rounded-full transition-all
                       {{ $filter === $key ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Daftar Postingan --}}
    @if($posts->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($posts as $post)
                <div class="post-item border rounded-lg shadow bg-white dark:bg-gray-800 dark:text-white overflow-hidden transition"
                     data-category="{{ $post->category }}">
                    @php
                        $coverPath = $post->cover_path;
                        $filePath  = $post->file_path;
                        $isImage   = $filePath && Str::endsWith($filePath, ['jpg','jpeg','png','gif','webp']);
                        $isMusic   = $post->category === 'music' && $filePath;
                    @endphp

                    {{-- Media Preview --}}
                    @if($coverPath)
                        <img src="{{ asset('storage/' . $coverPath) }}" 
                             alt="Cover {{ $post->title }}" 
                             loading="lazy"
                             class="w-full h-48 object-contain">
                    @elseif($post->category === 'images' && $isImage)
                        <img src="{{ asset('storage/' . $filePath) }}" 
                             alt="{{ $post->title }}"
                             loading="lazy"
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
                        {{-- Judul dengan read more (berdasarkan jumlah karakter) --}}
                        @php
                            $maxLength = 50; // batas karakter sebelum Read more muncul
                            $isLongTitle = strlen($post->title) > $maxLength;
                            $shortTitle = Str::limit($post->title, $maxLength, '');
                        @endphp

                        <h2 class="text-lg font-semibold mb-2 text-gray-900 dark:text-white break-title">
                            <span id="short-title-{{ $post->id }}">{{ $shortTitle }}</span>
                            @if($isLongTitle)
                                <span id="full-title-{{ $post->id }}" class="hidden">{{ $post->title }}</span>
                                ... <button onclick="toggleTitle({{ $post->id }})" class="text-red-500 hover:underline text-sm">Read more</button>
                            @endif
                        </h2>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">Kategori: {{ ucfirst($post->category) }}</p>
                        <p class="text-gray-500 dark:text-gray-400 text-sm mb-2">❤️ {{ $post->likes()->count() }} suka</p>

                        @if(!empty($post->content))
                            <p class="text-gray-700 dark:text-gray-300 text-sm mb-2">
                                {{ Str::limit($post->content, 100) }}
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

        {{-- Pagination --}}
        <div class="mt-6">
            {{ $posts->withQueryString()->links() }}
        </div>
    @else
        <p class="text-gray-500 dark:text-gray-400">Belum ada posting.</p>
    @endif
</div>
@endsection