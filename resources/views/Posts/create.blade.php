@extends('layouts.dashboard')

@section('content')
    <h1>Buat Postingan Baru</h1>

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        <input type="text" name="title" placeholder="Judul">
        <textarea name="content" placeholder="Isi konten"></textarea>
        <button type="submit">Simpan</button>
    </form>
@endsection