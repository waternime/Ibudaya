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

        <!-- Kategori File -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Kategori File</label>
            <select name="category" id="category" class="w-full border p-2 rounded" required>
                <option value="images" {{ old('category', $post->category) === 'images' ? 'selected' : '' }}>🖼️ Gambar</option>
                <option value="music" {{ old('category', $post->category) === 'music' ? 'selected' : '' }}>🎵 Musik</option>
                <option value="videos" {{ old('category', $post->category) === 'videos' ? 'selected' : '' }}>🎬 Video</option>
                <option value="docs" {{ old('category', $post->category) === 'docs' ? 'selected' : '' }}>📄 Dokumen</option>
            </select>
        </div>

        <!-- Provinsi -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Provinsi</label>
            <select name="province" class="w-full border p-2 rounded" required>
                <option value="">🌍 Pilih Provinsi</option>
                <option value="Umum" {{ old('province', $post->province) == 'Umum' ? 'selected' : '' }}>Umum / Nasional</option>
                <option value="Aceh" {{ old('province', $post->province) == 'Aceh' ? 'selected' : '' }}>Aceh</option>
                <option value="Sumatera Utara" {{ old('province', $post->province) == 'Sumatera Utara' ? 'selected' : '' }}>Sumatera Utara</option>
                <option value="Sumatera Barat" {{ old('province', $post->province) == 'Sumatera Barat' ? 'selected' : '' }}>Sumatera Barat</option>
                <option value="Riau" {{ old('province', $post->province) == 'Riau' ? 'selected' : '' }}>Riau</option>
                <option value="Kepulauan Riau" {{ old('province', $post->province) == 'Kepulauan Riau' ? 'selected' : '' }}>Kepulauan Riau</option>
                <option value="Jambi" {{ old('province', $post->province) == 'Jambi' ? 'selected' : '' }}>Jambi</option>
                <option value="Sumatera Selatan" {{ old('province', $post->province) == 'Sumatera Selatan' ? 'selected' : '' }}>Sumatera Selatan</option>
                <option value="Bangka Belitung" {{ old('province', $post->province) == 'Bangka Belitung' ? 'selected' : '' }}>Bangka Belitung</option>
                <option value="Bengkulu" {{ old('province', $post->province) == 'Bengkulu' ? 'selected' : '' }}>Bengkulu</option>
                <option value="Lampung" {{ old('province', $post->province) == 'Lampung' ? 'selected' : '' }}>Lampung</option>
                <option value="DKI Jakarta" {{ old('province', $post->province) == 'DKI Jakarta' ? 'selected' : '' }}>DKI Jakarta</option>
                <option value="Jawa Barat" {{ old('province', $post->province) == 'Jawa Barat' ? 'selected' : '' }}>Jawa Barat</option>
                <option value="Banten" {{ old('province', $post->province) == 'Banten' ? 'selected' : '' }}>Banten</option>
                <option value="Jawa Tengah" {{ old('province', $post->province) == 'Jawa Tengah' ? 'selected' : '' }}>Jawa Tengah</option>
                <option value="DI Yogyakarta" {{ old('province', $post->province) == 'DI Yogyakarta' ? 'selected' : '' }}>DI Yogyakarta</option>
                <option value="Jawa Timur" {{ old('province', $post->province) == 'Jawa Timur' ? 'selected' : '' }}>Jawa Timur</option>
                <option value="Bali" {{ old('province', $post->province) == 'Bali' ? 'selected' : '' }}>Bali</option>
                <option value="Nusa Tenggara Barat" {{ old('province', $post->province) == 'Nusa Tenggara Barat' ? 'selected' : '' }}>Nusa Tenggara Barat</option>
                <option value="Nusa Tenggara Timur" {{ old('province', $post->province) == 'Nusa Tenggara Timur' ? 'selected' : '' }}>Nusa Tenggara Timur</option>
                <option value="Kalimantan Barat" {{ old('province', $post->province) == 'Kalimantan Barat' ? 'selected' : '' }}>Kalimantan Barat</option>
                <option value="Kalimantan Tengah" {{ old('province', $post->province) == 'Kalimantan Tengah' ? 'selected' : '' }}>Kalimantan Tengah</option>
                <option value="Kalimantan Selatan" {{ old('province', $post->province) == 'Kalimantan Selatan' ? 'selected' : '' }}>Kalimantan Selatan</option>
                <option value="Kalimantan Timur" {{ old('province', $post->province) == 'Kalimantan Timur' ? 'selected' : '' }}>Kalimantan Timur</option>
                <option value="Kalimantan Utara" {{ old('province', $post->province) == 'Kalimantan Utara' ? 'selected' : '' }}>Kalimantan Utara</option>
                <option value="Sulawesi Utara" {{ old('province', $post->province) == 'Sulawesi Utara' ? 'selected' : '' }}>Sulawesi Utara</option>
                <option value="Gorontalo" {{ old('province', $post->province) == 'Gorontalo' ? 'selected' : '' }}>Gorontalo</option>
                <option value="Sulawesi Tengah" {{ old('province', $post->province) == 'Sulawesi Tengah' ? 'selected' : '' }}>Sulawesi Tengah</option>
                <option value="Sulawesi Barat" {{ old('province', $post->province) == 'Sulawesi Barat' ? 'selected' : '' }}>Sulawesi Barat</option>
                <option value="Sulawesi Selatan" {{ old('province', $post->province) == 'Sulawesi Selatan' ? 'selected' : '' }}>Sulawesi Selatan</option>
                <option value="Sulawesi Tenggara" {{ old('province', $post->province) == 'Sulawesi Tenggara' ? 'selected' : '' }}>Sulawesi Tenggara</option>
                <option value="Maluku" {{ old('province', $post->province) == 'Maluku' ? 'selected' : '' }}>Maluku</option>
                <option value="Maluku Utara" {{ old('province', $post->province) == 'Maluku Utara' ? 'selected' : '' }}>Maluku Utara</option>
                <option value="Papua" {{ old('province', $post->province) == 'Papua' ? 'selected' : '' }}>Papua</option>
                <option value="Papua Barat" {{ old('province', $post->province) == 'Papua Barat' ? 'selected' : '' }}>Papua Barat</option>
                <option value="Papua Selatan" {{ old('province', $post->province) == 'Papua Selatan' ? 'selected' : '' }}>Papua Selatan</option>
                <option value="Papua Tengah" {{ old('province', $post->province) == 'Papua Tengah' ? 'selected' : '' }}>Papua Tengah</option>
                <option value="Papua Pegunungan" {{ old('province', $post->province) == 'Papua Pegunungan' ? 'selected' : '' }}>Papua Pegunungan</option>
            </select>
        </div>

        <!-- Kategori Budaya -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Kategori Budaya</label>
            <select name="file_category" class="w-full border p-2 rounded" required>
                <option value="">🎭 Pilih Kategori Budaya</option>
                <option value="pakaian_adat" {{ old('file_category', $post->file_category) == 'pakaian_adat' ? 'selected' : '' }}>👘 Pakaian Adat</option>
                <option value="upacara_adat" {{ old('file_category', $post->file_category) == 'upacara_adat' ? 'selected' : '' }}>🙏 Upacara Adat</option>
                <option value="makanan_khas" {{ old('file_category', $post->file_category) == 'makanan_khas' ? 'selected' : '' }}>🍲 Makanan Khas</option>
                <option value="lagu_daerah" {{ old('file_category', $post->file_category) == 'lagu_daerah' ? 'selected' : '' }}>🎶 Lagu Daerah</option>
                <option value="alat_musik" {{ old('file_category', $post->file_category) == 'alat_musik' ? 'selected' : '' }}>🥁 Alat Musik Tradisional</option>
                <option value="senjata_tradisional" {{ old('file_category', $post->file_category) == 'senjata_tradisional' ? 'selected' : '' }}>⚔️ Senjata Tradisional</option>
                <option value="alam" {{ old('file_category', $post->file_category) == 'alam' ? 'selected' : '' }}>⛰️ Alam</option>
                <option value="rumah_tradisional" {{ old('file_category', $post->file_category) == 'rumah_tradisional' ? 'selected' : '' }}>🏠 Rumah Tradisional</option>
                <option value="tari_tradisional" {{ old('file_category', $post->file_category) == 'tari_tradisional' ? 'selected' : '' }}>💃 Tari Tradisional</option>
                <option value="permainan_tradisional" {{ old('file_category', $post->file_category) == 'permainan_tradisional' ? 'selected' : '' }}>🎮 Permainan Tradisional</option>
                <option value="pertunjukan_daerah" {{ old('file_category', $post->file_category) == 'pertunjukan_daerah' ? 'selected' : '' }}>🎭 Pertunjukan Daerah</option>
                <option value="profil_daerah" {{ old('file_category', $post->file_category) == 'profil_daerah' ? 'selected' : '' }}>📜 Profil Daerah</option>
                <option value="cerita_rakyat" {{ old('file_category', $post->file_category) == 'cerita_rakyat' ? 'selected' : '' }}>📖 Cerita Rakyat</option>
                <option value="sejarah" {{ old('file_category', $post->file_category) == 'sejarah' ? 'selected' : '' }}>📚 Sejarah</option>
                <option value="event" {{ old('file_category', $post->file_category) == 'event' ? 'selected' : '' }}>🎉 Kegiatan/Event</option>
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
                    <a href="{{ asset('storage/' . $post->file_path) }}" target="_blank" class="text-red-600 hover:underline">
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