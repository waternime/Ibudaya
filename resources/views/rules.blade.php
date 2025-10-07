@extends('layouts.dashboard')

@section('content')
<div class="min-h-screen bg-gray-50 flex flex-col">
    <!-- Navbar -->
    <!-- Main Content -->
    <main class="flex-1 max-w-7xl mx-auto px-6 py-8 grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Sidebar -->

        <!-- Rules Content -->
        <section class="md:col-span-3 bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold text-gray-800 flex items-center space-x-2 mb-4">
                <span class="text-orange-600">🛡️</span>
                <span>Peraturan Pengguna</span>
            </h2>
            <p class="text-gray-700 mb-4">
                Untuk menjaga kenyamanan dan tujuan utama IBUDAYA, setiap pengguna wajib mematuhi aturan berikut:
            </p>
            <ul class="list-disc pl-6 space-y-2 text-gray-700">
                <li>Dilarang mengunggah konten yang mengandung unsur pornografi, kekerasan, ujaran kebencian, atau hal-hal yang tidak sesuai dengan norma masyarakat.</li>
                <li>Konten yang diunggah sebaiknya berkaitan dengan Indonesia, baik itu kebudayaan, seni, musik, video daerah, cerita rakyat, maupun tempat wisata yang bermanfaat untuk diketahui orang lain.</li>
                <li>Dilarang melakukan re-upload karya orang lain tanpa izin, apalagi sampai mengklaim atau menyebarkannya di platform lain.</li>
                <li>Konten yang melanggar akan segera dihapus, dan akun pengguna bisa dikenakan sanksi sesuai kebijakan IBUDAYA.</li>
            </ul>
            <p class="mt-6 text-gray-800 font-medium">
                Mari bersama-sama menjaga IBUDAYA agar tetap positif, edukatif, dan menghargai kebudayaan Indonesia. ✨
            </p>
        </section>
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t py-4 text-center text-sm text-gray-500">
        © 2025 IBUDAYA • Menghidupkan Warisan Nusantara
        <br>
        Dibuat dengan cinta untuk budaya Indonesia
    </footer>
</div>
@endsection
