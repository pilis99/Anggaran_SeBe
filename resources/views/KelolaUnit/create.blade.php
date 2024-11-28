@extends('layouts.main')

@section('title', 'Tambah Unit')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Tambah Unit</h1>

    <form action="{{ route('manage.unit.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="id_divisi" class="block text-sm font-medium text-gray-700">ID Divisi</label>
            <input type="text" name="id_divisi" id="id_divisi" value="{{ $nextId }}" class="border rounded w-full py-2 px-3 bg-gray-200 text-gray-600" readonly>
        </div>

        <div class="mb-4">
            <label for="nama_divisi" class="block text-sm font-medium text-gray-700">Nama Divisi</label>
            <input type="text" name="nama_divisi" id="nama_divisi" class="border rounded w-full py-2 px-3" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        <a href="{{ route('manage.unit') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
    </form>

    @if ($errors->any())
    <div class="bg-red-500 text-white p-4 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
</div>
@endsection
