@extends('layouts.main')

@section('title', 'Edit Pengajuan Anggaran')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Edit Pengajuan Anggaran</h1>

    <!-- Menampilkan pesan sukses -->
    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form pengajuan anggaran untuk edit -->
    <div class="mb-6">
        <h2 class="text-xl font-semibold">Form Edit Pengajuan Anggaran</h2>
        <form action="{{ route('pengajuan.update', $pengajuan->id_pengajuan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="id_divisi" class="block text-sm font-medium text-gray-700">Divisi</label>
                <select name="id_divisi" id="id_divisi" class="border rounded w-full py-2 px-3">
                    @foreach($divisis as $divisi)
                        <option value="{{ $divisi->id_divisi }}" {{ $divisi->id_divisi == $pengajuan->id_divisi ? 'selected' : '' }}>
                            {{ $divisi->nama_divisi }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="id_rekening" class="block text-sm font-medium text-gray-700">Rekening</label>
                <select name="id_rekening" id="id_rekening" class="border rounded w-full py-2 px-3">
                    @foreach($rekings as $rekening)
                        <option value="{{ $rekening->id_rekening }}" {{ $rekening->id_rekening == $pengajuan->id_rekening ? 'selected' : '' }}>
                            {{ $rekening->nomor_rek }} - {{ $rekening->alokasi_rekening }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="id_anggaran" class="block text-sm font-medium text-gray-700">Anggaran</label>
                <select name="id_anggaran" id="id_anggaran" class="border rounded w-full py-2 px-3">
                    @foreach($anggarans as $anggaran)
                        <option value="{{ $anggaran->id_anggaran }}" {{ $anggaran->id_anggaran == $pengajuan->id_anggaran ? 'selected' : '' }}>
                            {{ $anggaran->nama_anggaran }} (Rp {{ number_format($anggaran->jumlah, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="nama_pengajuan" class="block text-sm font-medium text-gray-700">Nama Pengajuan</label>
                <input type="text" name="nama_pengajuan" id="nama_pengajuan" class="border rounded w-full py-2 px-3"
                    value="{{ old('nama_pengajuan', $pengajuan->nama_pengajuan) }}" required>
            </div>

            <div class="mb-4">
                <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah Pengajuan</label>
                <input type="number" name="jumlah" id="jumlah" class="border rounded w-full py-2 px-3"
                    value="{{ old('jumlah', $pengajuan->jumlah) }}" required>
            </div>

            <div class="mb-4">
                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal Pengajuan</label>
                <input type="date" name="tanggal" id="tanggal" class="border rounded w-full py-2 px-3"
                    value="{{ old('tanggal', \Carbon\Carbon::parse($pengajuan->tanggal)->format('Y-m-d')) }}" required>
            </div>

            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update</button>
                <a href="{{ route('pengajuan.show') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
