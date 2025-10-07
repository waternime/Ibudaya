@extends('layouts.dashboard')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Manajemen Pengguna</h1>

    {{-- Form pencarian --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4 flex flex-col sm:flex-row gap-2">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari berdasarkan ID atau Nama"
            class="border rounded p-2 w-full sm:w-1/3">
        <div class="flex gap-2">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded w-full sm:w-auto">Cari</button>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-400 text-white px-4 py-2 rounded w-full sm:w-auto">Reset</a>
        </div>
    </form>

    {{-- Wrapper tabel untuk scroll horizontal --}}
    <div class="overflow-x-auto hidden sm:block">
        <table class="table-auto w-full border mt-4">
            <thead>
                <tr class="bg-gray-200">
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $user->id }}</td>
                        <td class="px-4 py-2 border">{{ $user->name }}</td>
                        <td class="px-4 py-2 border">{{ $user->email }}</td>
                        <td class="px-4 py-2 border text-center">
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                onsubmit="return confirm('Yakin mau hapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-2 border text-center">Tidak ada pengguna ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Card versi mobile --}}
    <div class="sm:hidden space-y-4 mt-4">
        @forelse ($users as $user)
            <div class="border rounded-lg p-4 shadow-sm bg-white">
                <p><span class="font-semibold">ID:</span> {{ $user->id }}</p>
                <p><span class="font-semibold">Nama:</span> {{ $user->name }}</p>
                <p><span class="font-semibold">Email:</span> {{ $user->email }}</p>
                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                    onsubmit="return confirm('Yakin mau hapus user ini?')" class="mt-2">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded w-full">Hapus</button>
                </form>
            </div>
        @empty
            <p class="text-center text-gray-500">Tidak ada pengguna ditemukan.</p>
        @endforelse
    </div>
</div>
@endsection