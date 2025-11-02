@extends('layouts.dashboard')

@section('title', 'Posting Gambar')

@section('content')
<div id="post-container-all" class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center">🖼️ Feed Gambar</h2>

    @forelse($posts as $post)
        {{-- Card Post --}}
        <div class="mb-10 border rounded-lg shadow bg-white overflow-hidden hover:shadow-lg hover:-translate-y-1 transition duration-200">

            {{-- Header --}}
                <div class="px-4 py-3 border-b">
                    {{-- Judul dengan read more (berdasarkan jumlah karakter) --}}
                    @php
                        $maxLength = 50; // batas karakter sebelum Read more muncul
                        $isLongTitle = strlen($post->title) > $maxLength;
                        $shortTitle = Str::limit($post->title, $maxLength, '');
                    @endphp

                    <p class="text-lg font-semibold mb-1 break-title">
                        <span id="short-title-{{ $post->id }}">{{ $shortTitle }}</span>
                        @if($isLongTitle)
                            <span id="full-title-{{ $post->id }}" class="hidden">{{ $post->title }}</span>
                            ... 
                            <button class="text-red-500 hover:underline text-sm"
                                    onclick="event.stopPropagation(); toggleTitle({{ $post->id }});">
                                Read more
                            </button>
                        @endif
                    </p>

                    {{-- Info tambahan di bawah judul --}}
                    <div class="text-xs text-gray-500 space-x-2">
                        <span>📌 {{ ucfirst($post->province) ?? 'Umum' }}</span>
                        <span>🎭 {{ ucfirst($post->file_category) ?? 'Tidak ada kategori' }}</span>
                        <span class="px-2 py-1 bg-gray-200 rounded">{{ ucfirst($post->category) }}</span>
                    </div>
                </div>

                {{-- Gambar utama --}}
                <div class="w-full bg-gray-100" 
                     onclick="event.preventDefault(); openModal('{{ asset('storage/' . $post->file_path) }}')">
                    <img src="{{ asset('storage/' . $post->file_path) }}" 
                        alt="{{ $post->title }}" 
                        loading="lazy"
                        class="w-full object-contain cursor-pointer transition-transform duration-200 hover:scale-[1.02]">
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
    @empty
        <p class="text-gray-500 text-center">Belum ada postingan gambar.</p>
    @endforelse
</div>

{{-- Loader kecil --}}
    <div id="loader" class="text-center py-4 hidden text-gray-500">
        ⏳ Memuat postingan...
    </div>
</div>

{{-- Modal Preview Gambar --}}
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50 p-4 transition-opacity duration-300">
    <button class="absolute top-5 right-8 text-white text-3xl font-bold hover:text-red-400" onclick="closeModal()">❌</button>
    <img id="modalImage" class="max-w-full max-h-[80vh] rounded shadow-lg object-contain transform transition-transform duration-300 scale-95 opacity-0" loading="lazy">
</div>
@endsection