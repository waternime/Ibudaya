@extends('layouts.dashboard')

@section('title', 'Dokumen')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold mb-6 text-center">📄 Feed Dokumen</h2>

    @forelse($posts as $post)
        {{-- Card Dokumen --}}
        <div class="mb-10 border rounded-lg shadow bg-white overflow-hidden hover:shadow-lg hover:-translate-y-1 transition duration-200">

            {{-- Header --}}
            <a href="{{ route('posts.show', $post->id) }}" class="block">
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
                        {{ $post->doc_type ? strtoupper($post->doc_type) : ucfirst($post->category) }}
                    </span>
                </div>
            </a>

            {{-- Thumbnail / Cover --}}
            @if($post->cover_path)
                <div class="w-full bg-gray-100"
                     onclick="event.preventDefault(); openModal('{{ asset('storage/' . $post->cover_path) }}')">
                    <img src="{{ asset('storage/' . $post->cover_path) }}" 
                         alt="Cover {{ $post->title }}" 
                         loading="lazy"
                         class="w-full object-contain cursor-pointer transition-transform duration-200 hover:scale-[1.02]">
                </div>
            @endif

            {{-- Tombol Aksi --}}
            <div class="flex flex-col sm:flex-row gap-2 px-4 py-3 border-b">
                <a href="{{ route('posts.download', $post->id) }}" 
                   class="flex-1 text-center px-3 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition-colors duration-200">
                    ⬇️ Download Dokumen
                </a>

                @if($post->doc_type === 'pdf')
                    <a href="{{ route('posts.preview', $post->id) }}" target="_blank" 
                       class="flex-1 text-center px-3 py-2 bg-gray-600 text-white text-sm rounded hover:bg-gray-700 transition-colors duration-200">
                        🔍 Preview PDF
                    </a>
                @endif
            </div>

            {{-- Like & Comment --}}
            <div class="px-4 py-3 text-lg">
                <p class="text-gray-400 text-xs mb-2">
                    Dibuat: {{ $post->created_at->diffForHumans() }}
                </p>
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
        <p class="text-gray-600 text-center">Belum ada dokumen yang diunggah.</p>
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
        image.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 200);
    }
</script>
@endsection