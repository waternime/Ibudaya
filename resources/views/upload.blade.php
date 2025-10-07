@extends('layouts.dashboard')

@section('title', 'Upload Postingan')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow p-6 rounded">
    <h2 class="text-2xl font-bold mb-6">⏫ Upload Postingan</h2>

    <!-- Alert sukses -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Upload -->
    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Judul -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Judul</label>
            <input type="text" name="title" value="{{ old('title') }}" 
                   class="w-full border p-2 rounded" required>
            @error('title')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- File Utama -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Pilih File</label>
            <input type="file" name="file" class="w-full border p-2 rounded" required>
            @error('file')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Kategori -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Kategori</label>
            <select name="category" id="category" class="w-full border p-2 rounded" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="images" {{ old('category') === 'images' ? 'selected' : '' }}>🖼️ Gambar</option>
                <option value="music" {{ old('category') === 'music' ? 'selected' : '' }}>🎵 Musik</option>
                <option value="videos" {{ old('category') === 'videos' ? 'selected' : '' }}>🎬 Video</option>
                <option value="docs" {{ old('category') === 'docs' ? 'selected' : '' }}>📄 Dokumen</option>
            </select>
            @error('category')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Thumbnail (khusus docs & video) -->
        <div class="mb-4 {{ old('category') === 'docs' || old('category') === 'videos' ? '' : 'hidden' }}" id="thumbnail-wrapper">
            <label class="block font-semibold mb-1">Upload Thumbnail (opsional)</label>
            <input type="file" name="cover" class="w-full border p-2 rounded" accept="image/*">
            <p class="text-gray-500 text-sm mt-1">Gunakan JPG/PNG sebagai sampul dokumen atau video (max 2MB).</p>
            @error('cover')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol -->
        <div class="text-right">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Upload
            </button>
        </div>
    </form>
</div>

<script>
    // JS toggle input cover image
    document.getElementById('category').addEventListener('change', function () {
        let wrapper = document.getElementById('thumbnail-wrapper');
        if (this.value === 'docs' || this.value === 'videos') {
            wrapper.classList.remove('hidden');
        } else {
            wrapper.classList.add('hidden');
        }
    });
</script>
@endsection