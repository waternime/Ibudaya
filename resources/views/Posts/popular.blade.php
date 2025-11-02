@extends('layouts.dashboard')

@section('title', 'Postingan Populer')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">⭐ Postingan Populer</h1>

    @if ($posts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach ($posts as $post)
                {{-- Skip kategori musik --}}
                @if($post->category === 'music')
                    @continue
                @endif

                @php
                    $coverPath = $post->cover_path;
                    $filePath  = $post->file_path;
                    $isImage   = $filePath && \Illuminate\Support\Str::endsWith($filePath, ['jpg','jpeg','png','gif','webp']);

                    // Warna label ranking
                    $rankColor = match($loop->iteration) {
                        1 => 'bg-yellow-400 text-black', // emas
                        2 => 'bg-gray-300 text-black',   // perak
                        3 => 'bg-amber-600 text-white',  // perunggu
                        default => 'bg-red-500 text-white'
                    };
                @endphp

                <div class="border rounded-lg shadow bg-white overflow-hidden">
                    {{-- Cover atau file image --}}
                    @if ($coverPath)
                        <div class="w-full bg-gray-100 flex justify-center relative">
                            <img src="{{ asset('storage/' . $coverPath) }}"
                                 alt="Cover {{ $post->title }}"
                                 loading="lazy"
                                 class="w-full h-48 object-contain">

                            {{-- Nomor Ranking --}}
                            <span class="absolute top-2 left-2 px-3 py-1 rounded font-bold {{ $rankColor }}">
                                #{{ $loop->iteration }}
                            </span>
                        </div>
                    @elseif ($post->category === 'images' && $isImage)
                        <div class="w-full bg-gray-100 flex justify-center relative">
                            <img src="{{ asset('storage/' . $filePath) }}"
                                 alt="{{ $post->title }}" 
                                 loading="lazy"
                                 class="w-full h-48 object-contain">

                            {{-- Nomor Ranking --}}
                            <span class="absolute top-2 left-2 px-3 py-1 rounded font-bold {{ $rankColor }}">
                                #{{ $loop->iteration }}
                            </span>
                        </div>
                    @else
                        {{-- Jika tidak ada gambar --}}
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center relative">
                            <span class="text-gray-500">Tidak ada gambar</span>
                            <span class="absolute top-2 left-2 px-3 py-1 rounded font-bold {{ $rankColor }}">
                                #{{ $loop->iteration }}
                            </span>
                        </div>
                    @endif

                    {{-- Konten --}}
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
                        
                        <p class="text-gray-600 text-sm mb-2">
                            Kategori: {{ ucfirst($post->category) }}
                        </p>
                        
                        <p class="text-gray-500 text-sm mb-2">
                            ❤️ {{ $post->likes_count }} suka
                        </p>

                        <p class="text-gray-400 text-xs">
                            Diunggah: {{ $post->created_at->diffForHumans() }}
                        </p>

                        <a href="{{ route('posts.show', $post->id) }}" 
                           class="block w-full text-center px-3 py-2 bg-red-600 text-white rounded hover:bg-red-700 mt-2">
                            Lihat Selengkapnya
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-gray-600">Belum ada postingan populer dengan cover/gambar.</p>
    @endif
</div>
@endsection