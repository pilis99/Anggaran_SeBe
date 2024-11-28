@extends('layouts.main')

@section('title', 'Edit Unit')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Edit Unit</h1>

    <form action="{{ route('manage.unit.update', $divisi->id_divisi) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="id_divisi" class="block text-sm font-medium text-gray-700">ID Divisi</label>
            <input type="text" name="id_divisi" id="id_divisi" value="{{ $divisi->id_divisi }}" class="border rounded w-full py-2 px-3 bg-gray-200 text-gray-600" readonly>
        </div>

        <div class="mb-4">
            <label for="nama_divisi" class="block text-sm font-medium text-gray-700">Nama Divisi</label>
            <input type="text" name="nama_divisi" id="nama_divisi" value="{{ $divisi->nama_divisi }}" class="border rounded w-full py-2 px-3" required>
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
