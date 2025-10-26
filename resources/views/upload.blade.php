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

        <!-- Provinsi -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Provinsi</label>
            <select name="province" class="w-full border p-2 rounded" required>
                <option value="">-- Pilih Provinsi --</option>
                <option value="Umum">🌐 Umum / Nasional</option>
                <option value="Aceh">Aceh</option>
                <option value="Sumatera Utara">Sumatera Utara</option>
                <option value="Sumatera Barat">Sumatera Barat</option>
                <option value="Riau">Riau</option>
                <option value="Kepulauan Riau">Kepulauan Riau</option>
                <option value="Jambi">Jambi</option>
                <option value="Sumatera Selatan">Sumatera Selatan</option>
                <option value="Bangka Belitung">Bangka Belitung</option>
                <option value="Bengkulu">Bengkulu</option>
                <option value="Lampung">Lampung</option>
                <option value="DKI Jakarta">DKI Jakarta</option>
                <option value="Jawa Barat">Jawa Barat</option>
                <option value="Banten">Banten</option>
                <option value="Jawa Tengah">Jawa Tengah</option>
                <option value="DI Yogyakarta">DI Yogyakarta</option>
                <option value="Jawa Timur">Jawa Timur</option>
                <option value="Bali">Bali</option>
                <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
                <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
                <option value="Kalimantan Barat">Kalimantan Barat</option>
                <option value="Kalimantan Tengah">Kalimantan Tengah</option>
                <option value="Kalimantan Selatan">Kalimantan Selatan</option>
                <option value="Kalimantan Timur">Kalimantan Timur</option>
                <option value="Kalimantan Utara">Kalimantan Utara</option>
                <option value="Sulawesi Utara">Sulawesi Utara</option>
                <option value="Gorontalo">Gorontalo</option>
                <option value="Sulawesi Tengah">Sulawesi Tengah</option>
                <option value="Sulawesi Barat">Sulawesi Barat</option>
                <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                <option value="Sulawesi Tenggara">Sulawesi Tenggara</option>
                <option value="Maluku">Maluku</option>
                <option value="Maluku Utara">Maluku Utara</option>
                <option value="Papua">Papua</option>
                <option value="Papua Barat">Papua Barat</option>
                <option value="Papua Selatan">Papua Selatan</option>
                <option value="Papua Tengah">Papua Tengah</option>
                <option value="Papua Pegunungan">Papua Pegunungan</option>
            </select>
            @error('province')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Jenis File -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Jenis File</label>
            <select name="category" id="category" class="w-full border p-2 rounded" required>
                <option value="">-- Pilih Jenis File --</option>
                <option value="images">🖼️ Gambar</option>
                <option value="music">🎵 Musik</option>
                <option value="videos">🎬 Video</option>
                <option value="docs">📄 Dokumen</option>
            </select>
        </div>

        <!-- Kategori Budaya -->
        <div class="mb-4">
            <label class="block font-semibold mb-1">Kategori Budaya</label>
            <select name="file_category" class="w-full border p-2 rounded" required>
                <option value="">-- Pilih Kategori --</option>
                <option value="pakaian_adat">👘 Pakaian Adat</option>
                <option value="upacara_adat">🙏 Upacara Adat</option>
                <option value="makanan_khas">🍲 Makanan Khas</option>
                <option value="lagu_daerah">🎶 Lagu Daerah</option>
                <option value="alat_musik">🥁 Alat Musik Tradisional</option>
                <option value="senjata_tradisional">⚔️ Senjata Tradisional</option>
                <option value="alam">⛰️ Alam</option>
                <option value="rumah_tradisional">🏠 Rumah Tradisional</option>
                <option value="tari_tradisional">💃 Tari Tradisional</option>
                <option value="permainan_tradisional">🎮 Permainan Tradisional</option>
                <option value="pertunjukan_daerah">🎭 Pertunjukan Daerah</option>
                <option value="profil_daerah">📜 Profil Daerah</option>
                <option value="cerita_rakyat">📖 Cerita Rakyat</option>
                <option value="sejarah">📚 Sejarah</option>
                <option value="event">🎉 Kegiatan/Event</option>
            </select>
        </div>

        <!-- Thumbnail (hanya kalau file video/docs) -->
        <div class="mb-4 hidden" id="thumbnail-wrapper">
            <label class="block font-semibold mb-1">Upload Thumbnail (opsional)</label>
            <input type="file" name="cover" class="w-full border p-2 rounded" accept="image/*">
            <p class="text-gray-500 text-sm mt-1">Gunakan JPG/PNG (max 2MB)</p>
        </div>

        <!-- Tombol -->
        <div class="text-right">
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
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