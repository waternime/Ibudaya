@extends('layouts.dashboard')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-extrabold mb-6 text-gray-800 dark:text-gray-100">👥 Manajemen Pengguna</h1>
    <p class="text-gray-600 dark:text-gray-400 mb-4">Kelola seluruh akun pengguna yang terdaftar di sistem.</p>

    {{-- Form Pencarian --}}
    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4 flex flex-col sm:flex-row gap-2">
        <input type="text" name="search" value="{{ request('search') }}"
            placeholder="Cari pengguna berdasarkan nama atau ID..."
            class="w-full sm:flex-1 px-4 py-2 border rounded-lg focus:ring focus:ring-red-300 dark:bg-gray-800 dark:text-gray-100 dark:border-gray-700">
        <div class="flex gap-2">
            <button type="submit"
                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 w-full sm:w-auto">
                Cari
            </button>
            @if(request('search'))
                <a href="{{ route('admin.users.index') }}"
                   class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 w-full sm:w-auto text-center">
                    Reset
                </a>
            @endif
        </div>
    </form>

    @if($users->count() > 0)
        {{-- Tabel Desktop --}}
        <div class="overflow-x-auto shadow rounded-lg border border-gray-200 dark:border-gray-700 hidden sm:block">
            <table class="min-w-full bg-white dark:bg-gray-900">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-800 text-left text-gray-700 dark:text-gray-200">
                        <th class="px-4 py-3 border border-gray-200 dark:border-gray-700">ID</th>
                        <th class="px-4 py-3 border border-gray-200 dark:border-gray-700">Nama</th>
                        <th class="px-4 py-3 border border-gray-200 dark:border-gray-700">Email</th>
                        <th class="px-4 py-3 border border-gray-200 dark:border-gray-700 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-4 py-2 border border-gray-200 dark:border-gray-700 text-gray-800 dark:text-gray-200">
                                {{ $user->id }}
                            </td>
                            <td class="px-4 py-2 border border-gray-200 dark:border-gray-700 font-medium text-red-500 dark:text-red-400">
                                {{ $user->name }}
                            </td>
                            <td class="px-4 py-2 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300">
                                {{ $user->email }}
                            </td>
                            <td class="px-4 py-2 border border-gray-200 dark:border-gray-700 text-center">
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin mau hapus user ini?')" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white text-sm rounded">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Card Mobile --}}
        <div class="sm:hidden space-y-4 mt-4">
            @foreach($users as $user)
                <div class="border rounded-lg p-4 shadow-sm bg-white dark:bg-gray-900 border-gray-200 dark:border-gray-700">
                    <p class="text-sm text-gray-500 dark:text-gray-400">#{{ $user->id }}</p>
                    <p class="font-semibold text-red-500 dark:text-red-400">{{ $user->name }}</p>
                    <p class="text-gray-700 dark:text-gray-300 text-sm">{{ $user->email }}</p>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                        onsubmit="return confirm('Yakin mau hapus user ini?')" class="mt-3">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white w-full py-2 rounded">
                            Hapus
                        </button>
                    </form>
                </div>
            @endforeach
        </div>

        {{-- Pagination Info + Navigasi --}}
        <div class="mt-6 flex flex-col sm:flex-row items-center justify-between text-sm text-gray-600 dark:text-gray-400 gap-3">
            <div>
                Showing 
                <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $users->firstItem() }}</span> 
                to 
                <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $users->lastItem() }}</span> 
                of 
                <span class="font-semibold text-gray-800 dark:text-gray-200">{{ $users->total() }}</span> 
                results
            </div>

            <div>
                {{ $users->appends(request()->query())->onEachSide(1)->links('pagination::tailwind') }}
            </div>
        </div>
    @else
        <p class="text-gray-500 italic dark:text-gray-400">Tidak ada pengguna ditemukan.</p>
    @endif
</div>
@endsection