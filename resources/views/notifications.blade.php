@extends('layouts.dashboard')

@section('content')
<div class="container">
    <h3 class="mb-3">Notifikasi</h3>

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
                            <a href="{{ route('posts.show', $notif->post->id) }}" class="font-semibold text-blue-600 hover:underline">
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