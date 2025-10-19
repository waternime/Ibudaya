@extends('layouts.dashboard')

@section('title', 'Posting Gambar')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center">🖼️ Feed Gambar</h2>

    @forelse($posts as $post)
        {{-- Card Post --}}
        <div class="mb-10 border rounded-lg shadow bg-white overflow-hidden hover:shadow-lg hover:-translate-y-1 transition duration-200">

            {{-- Bungkus isi utama dengan link ke detail --}}
            <a href="{{ route('posts.show', $post->id) }}" class="block">

                {{-- Header --}}
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
                        {{ ucfirst($post->category) }}
                    </span>
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

{{-- Modal Preview Gambar --}}
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-70 hidden items-center justify-center z-50 p-4 transition-opacity duration-300">
    <button class="absolute top-5 right-8 text-white text-3xl font-bold hover:text-red-400" onclick="closeModal()">❌</button>
    <img id="modalImage" class="max-w-full max-h-[80vh] rounded shadow-lg object-contain transform transition-transform duration-300 scale-95 opacity-0" loading="lazy">
</div>

{{-- Script Modal --}}
<script>
    function openModal(src) {
        const modal = document.getElementById('imageModal');
        const image = document.getElementById('modalImage');
        image.src = src;

        // animasi fade in
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            image.classList.remove('scale-95', 'opacity-0');
            image.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModal() {
        const modal = document.getElementById('imageModal');
        const image = document.getElementById('modalImage');
        // animasi fade out
        image.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 200);
    }
</script>
@endsection