@extends('layouts.dashboard')

@section('title', 'Edit Postingan')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow p-6 rounded">
    <h2 class="text-2xl font-bold mb-6">✏️ Edit Postingan</h2>

    <!-- Alert sukses -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Edit -->
    <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Judul -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Judul</label>
            <input type="text" name="title" class="w-full border p-2 rounded" 
                   value="{{ old('title', $post->title) }}" required>
        </div>

        <!-- Kategori -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Kategori</label>
            <select name="category" id="category" class="w-full border p-2 rounded" required>
                <option value="images" {{ old('category', $post->category) === 'images' ? 'selected' : '' }}>🖼️ Gambar</option>
                <option value="music" {{ old('category', $post->category) === 'music' ? 'selected' : '' }}>🎵 Musik</option>
                <option value="videos" {{ old('category', $post->category) === 'videos' ? 'selected' : '' }}>🎬 Video</option>
                <option value="docs" {{ old('category', $post->category) === 'docs' ? 'selected' : '' }}>📄 Dokumen</option>
            </select>
        </div>

        <!-- File lama -->
        @if($post->file_path)
            <div class="mb-4">
                <p class="text-gray-600 mb-2">File saat ini:</p>
                @php
                    $isImage = \Illuminate\Support\Str::endsWith($post->file_path, ['jpg','jpeg','png','gif','webp']);
                @endphp
                @if($isImage)
                    <img src="{{ asset('storage/' . $post->file_path) }}" alt="File Lama" class="w-full h-48 object-contain mb-2">
                @else
                    <a href="{{ asset('storage/' . $post->file_path) }}" target="_blank" class="text-blue-600 hover:underline">
                        Lihat File Saat Ini
                    </a>
                @endif
            </div>
        @endif

        <!-- Upload file baru -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Ganti File (Opsional)</label>
            <input type="file" name="file_path" class="w-full border p-2 rounded" accept="*/*">
            <p class="text-gray-500 text-sm mt-1">Upload file baru jika ingin mengganti file lama. Untuk dokumen/video, bisa tambahkan cover (max 2MB).</p>
        </div>

        <!-- Upload cover baru -->
        <div class="mb-4" id="cover-wrapper">
            <label class="block font-semibold mb-1">Ganti Cover (Opsional)</label>
            <input type="file" name="cover_path" class="w-full border p-2 rounded" accept="image/*">
            <p class="text-gray-500 text-sm mt-1">Hanya untuk dokumen atau video, max 2MB.</p>
        </div>

        <!-- Tombol Submit -->
        <div class="text-right">
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
    // JS toggle input cover image
    document.getElementById('category').addEventListener('change', function () {
        let wrapper = document.getElementById('cover-wrapper');
        if (this.value === 'docs' || this.value === 'videos') {
            wrapper.classList.remove('hidden');
        } else {
            wrapper.classList.add('hidden');
        }
    });

    // Hide cover input by default if category bukan docs/videos
    window.addEventListener('load', function () {
        let wrapper = document.getElementById('cover-wrapper');
        let category = document.getElementById('category').value;
        if (category !== 'docs' && category !== 'videos') {
            wrapper.classList.add('hidden');
        }
    });
</script>
@endsection