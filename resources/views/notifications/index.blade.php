@extends('layouts.dashboard')

@section('title','Notifikasi')

@section('content')
    <h1>Notifikasi</h1>

    @if(!empty($notifications) && count($notifications))
        <ul>
            @foreach($notifications as $n)
                <li>{{ $n->message ?? 'Isi notifikasi contoh' }}</li>
            @endforeach
        </ul>
    @else
        <p>Tidak ada notifikasi saat ini.</p>
    @endif
@endsection