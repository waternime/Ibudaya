@extends('layouts.dashboard')

@section('title', 'Profile')

@section('content')
<div class="container mx-auto p-4">
    {{-- Header Profil --}}
    <div class="flex items-center gap-4 mb-6">
        @if(Auth::user()->profile_picture)
            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" 
                 alt="Foto Profil {{ Auth::user()->name }}"
                 loading="lazy"
                 class="w-16 h-16 rounded-full object-cover border">
        @else
            <div class="w-16 h-16 flex items-center justify-center bg-gray-300 rounded-full text-2xl">👤</div>
        @endif

        <div>
            <h1 class="text-3xl font-extrabold mb-1">{{ Auth::user()->name ?? 'Tamu' }}</h1>
            <a href="{{ route('profile.edit') }}" 
               class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-sm">
               ✏️ Edit Profile
            </a>
            @if(Auth::check())
                <p class="text-gray-600 mt-1">ID : ({{ Auth::user()->id }})</p>
            @endif
        </div>
    </div>

    {{-- Filter Kategori --}}
    <div class="mb-6 flex flex-wrap gap-2 justify-start">
        @php $filter = request('filter', 'all'); @endphp
        @foreach ([
            'all' => 'Semua',
            'images' => 'Gambar',
            'music' => 'Musik',
            'videos' => 'Video',
            'docs' => 'Dokumen',
        ] as $key => $label)
            <a href="{{ route('profile', ['filter' => $key]) }}"
               class="filter-btn px-4 py-2 rounded-full transition-all text-sm font-medium
                      {{ $filter === $key ? 'bg-red-600 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Daftar Postingan --}}
    @if($posts->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($posts as $post)
                @php
                    $file = $post->file_path;
                    $cover = $post->cover_path;
                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                    $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp']);
                    $isVideo = in_array($ext, ['mp4','webm']);
                    $isMusic = in_array($ext, ['mp3','wav','ogg']);
                @endphp

                <div class="border rounded-xl shadow bg-white dark:bg-gray-800 dark:text-white overflow-hidden transition hover:shadow-lg">
                    {{-- Media Preview --}}
                    <div class="w-full h-48 bg-gray-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden">
                        @if($cover)
                            <img src="{{ asset('storage/'.$cover) }}" 
                                 alt="Cover {{ $post->title }}" 
                                 loading="lazy" 
                                 class="object-contain w-full h-full">
                        @elseif($isImage)
                            <img src="{{ asset('storage/'.$file) }}" 
                                 alt="{{ $post->title }}" 
                                 loading="lazy" 
                                 class="object-contain w-full h-full">
                        @elseif($isVideo)
                            <video controls preload="none" class="w-full h-full object-contain">
                                <source src="{{ asset('storage/'.$file) }}" type="video/mp4">
                                Browser kamu tidak mendukung video.
                            </video>
                        @elseif($isMusic)
                            <div class="flex flex-col justify-center items-center text-center p-4 w-full h-full">
                                🎵 <p class="mt-2 font-semibold">{{ $post->title }}</p>
                                <audio controls preload="none" class="mt-2 w-full">
                                    <source src="{{ asset('storage/'.$file) }}" type="audio/mpeg">
                                </audio>
                            </div>
                        @else
                            <div class="flex flex-col justify-center items-center text-center text-gray-600 w-full h-full">
                                📄 <p class="mt-2 text-sm">Dokumen</p>
                                <a href="{{ asset('storage/'.$file) }}" target="_blank" 
                                   class="text-red-600 hover:underline text-sm mt-1">Lihat Dokumen</a>
                            </div>
                        @endif
                    </div>

                    {{-- Konten --}}
                    <div class="p-4">
                        @php
                            $max = 60;
                            $long = strlen($post->title) > $max;
                            $short = Str::limit($post->title, $max, '');
                        @endphp

                        <h2 class="text-base font-semibold mb-1">
                            <span id="short-title-{{ $post->id }}">{{ $short }}</span>
                            @if($long)
                                <span id="full-title-{{ $post->id }}" class="hidden">{{ $post->title }}</span>
                                ... <button onclick="toggleTitle({{ $post->id }})" class="text-red-500 hover:underline text-xs">Read more</button>
                            @endif
                        </h2>

                        <p class="text-gray-600 dark:text-gray-400 text-xs mb-1">Kategori: {{ ucfirst($post->category) }}</p>
                        <p class="text-gray-500 dark:text-gray-400 text-xs mb-2">❤️ {{ $post->likes()->count() }} suka</p>

                        @if(!empty($post->content))
                            <p class="text-gray-700 dark:text-gray-300 text-sm mb-2">
                                {{ Str::limit($post->content, 80) }}
                            </p>
                        @endif

                        <a href="{{ route('posts.show', $post->id) }}" 
                           class="block text-center px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                           Lihat Selengkapnya
                        </a>

                        <div class="flex justify-between mt-2">
                            <a href="{{ route('posts.edit', $post->id) }}" 
                               class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-xs">✏️ Edit</a>

                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus postingan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 text-xs">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8 flex justify-center">
            {{ $posts->withQueryString()->links() }}
        </div>
    @else
        <p class="text-gray-500 dark:text-gray-400 text-center mt-10">Belum ada posting.</p>
    @endif
</div>
@endsection