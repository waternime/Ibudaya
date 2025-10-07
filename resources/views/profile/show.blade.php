@extends('layouts.dashboard')

@section('content')
<div class="bg-white shadow rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-4">Profilku</h2>

    <p><strong>Nama:</strong> {{ $user->name }}</p>
    <p><strong>Email:</strong> {{ $user->email }}</p>

    <div class="mt-4">
        <a href="{{ route('profile.edit') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Edit Profil</a>
    </div>
</div>
@endsection