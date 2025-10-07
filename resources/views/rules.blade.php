@extends('layouts.dashboard')

@section('title', 'Peraturan Pengguna')

@section('content')
<div class="max-w-3xl mx-auto bg-white shadow rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-4">📜 Peraturan Pengguna</h2>
    <p class="mb-4">Untuk menjaga kenyamanan dan tujuan utama Ibudaya, setiap pengguna diwajibkan mematuhi aturan berikut:</p>
    
    <ul class="list-disc pl-6 space-y-2">
        <li>Dilarang mengunggah konten yang mengandung unsur pornografi, kekerasan, ujaran kebencian, atau hal-hal yang tidak sesuai dengan norma masyarakat.</li>
        <li>Konten yang diunggah sebaiknya berkaitan dengan Indonesia, baik itu kebudayaan, seni, musik, video daerah, cerita rakyat, maupun tempat wisata yang bermanfaat untuk diketahui orang lain.</li>
        <li>Dilarang melakukan <i>re-upload</i> karya orang lain tanpa izin, apalagi sampai mengklaim atau menyebarkannya di platform lain.</li>
        <li>Konten yang melanggar akan segera dihapus, dan akun pengguna bisa dikenakan sanksi sesuai kebijakan Ibudaya.</li>
    </ul>

    <p class="mt-6 font-semibold">Mari bersama-sama menjaga Ibudaya agar tetap positif, edukatif, dan menghargai kebudayaan Indonesia. 🙌</p>
</div>
@endsection