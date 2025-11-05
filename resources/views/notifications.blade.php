@extends('layouts.dashboard')

@section('title', 'Notifikasi')

@section('content')
<div class="container mx-auto p-4">

    {{-- Header + tombol Hapus Semua --}}
    <div class="flex justify-between items-center mb-4">
        <h3 class="text-xl font-semibold">Notifikasi</h3>

        @if($notifications->count())
            <form action="{{ route('notifications.clear') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus semua notifikasi?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                    Hapus Semua
                </button>
            </form>
        @endif
    </div>

    {{-- Flash message --}}
    @if(session('success'))
        <div class="mb-4 p-2 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    {{-- Daftar notifikasi --}}
    <div class="notifications-wrapper">
        @forelse ($notifications as $notif)
            <div class="notification-card {{ $notif->is_read ? 'read' : 'unread' }} flex items-center gap-3 p-3 border rounded mb-2">

                {{-- Thumbnail gambar/postingan jika ada --}}
                @if($notif->post && ($notif->post->cover_path || ($notif->post->file_path && \Illuminate\Support\Str::endsWith($notif->post->file_path, ['jpg','jpeg','png','gif','webp']))))
                    @php
                        $imagePath = $notif->post->cover_path ?? $notif->post->file_path;
                    @endphp
                    <img src="{{ asset('storage/' . $imagePath) }}" alt="Thumbnail" class="w-12 h-12 object-cover rounded">
                @endif

                <div class="flex-1">
                    <p class="mb-1">
                        {{ $notif->message }}

                        {{-- Judul postingan klikable --}}
                        @if ($notif->post)
                            <br>
                            <a href="{{ route('posts.show', $notif->post->id) }}" class="font-semibold text-red-600 hover:underline">
                                📌 {{ $notif->post->title }}
                            </a>
                        @endif
                    </p>
                    <small class="time text-gray-500">{{ $notif->created_at->diffForHumans() }}</small>
                </div>

            </div>
        @empty
            <div class="alert alert-secondary">Tidak ada notifikasi</div>
        @endforelse
    </div>
</div>
@endsection