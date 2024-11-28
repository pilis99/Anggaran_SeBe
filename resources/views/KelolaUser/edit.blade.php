@extends('layouts.main')

@section('title', 'Edit User')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Edit User</h1>

    <form action="{{ route('manage.user.update', $user->id_user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="nama_user" class="block text-sm font-medium text-gray-700">Nama User</label>
            <input type="text" name="nama_user" id="nama_user" class="border rounded w-full py-2 px-3" value="{{ $user->nama_user }}" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="border rounded w-full py-2 px-3" value="{{ $user->email }}" required>
        </div>

        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
            <select name="role" id="role" class="border rounded w-full py-2 px-3" required>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="kepala_divisi" {{ $user->role == 'kepala_divisi' ? 'selected' : '' }}>Kepala Divisi</option>
            </select>
        </div>

        <!-- Menampilkan Divisi hanya jika role 'kepala_divisi' -->
        @if($user->role == 'kepala_divisi')
        <div class="mb-4">
            <label for="id_divisi" class="block text-sm font-medium text-gray-700">Divisi</label>
            <select name="id_divisi" id="id_divisi" class="border rounded w-full py-2 px-3">
                <option value="">Pilih Divisi</option>
                @foreach($divisis as $divisi)
                    <option value="{{ $divisi->id_divisi }}" {{ $user->id_divisi == $divisi->id_divisi ? 'selected' : '' }}>
                        {{ $divisi->nama_divisi }}
                    </option>
                @endforeach
            </select>
        </div>
        @endif

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password (Kosongkan jika tidak ingin mengubah)</label>
            <input type="password" name="password" id="password" class="border rounded w-full py-2 px-3">
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="border rounded w-full py-2 px-3">
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
        <a href="{{ route('manage.user') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
    </form>
</div>
@endsection
