@extends('layouts.main')

@section('title', 'Edit Anggaran')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Edit Anggaran</h1>
    <form method="POST" action="{{ route('manage.data.anggaran.update', $anggaran->id_anggaran) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama_anggaran" class="form-label">Nama Anggaran</label>
            <input type="text" class="form-control" id="nama_anggaran" name="nama_anggaran" value="{{ old('nama_anggaran', $anggaran->nama_anggaran) }}" required>
        </div>

        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" value="{{ old('jumlah', $anggaran->jumlah) }}" required>
        </div>

        <div class="mb-3">
            <label for="tanggal" class="form-label">Tanggal</label>
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ old('tanggal', $anggaran->tanggal) }}" required>
        </div>

        <div class="mb-3">
            <label for="id_divisi" class="form-label">Divisi</label>
            <select class="form-select" id="id_divisi" name="id_divisi" required>
                @foreach($divisis as $divisi)
                    <option value="{{ $divisi->id_divisi }}" {{ $anggaran->id_divisi == $divisi->id_divisi ? 'selected' : '' }}>
                        {{ $divisi->nama_divisi }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="id_rekening" class="form-label">Rekening</label>
            <select class="form-select" id="id_rekening" name="id_rekening" required>
                @foreach($rekings as $rekening)
                    <option value="{{ $rekening->id_rekening }}" {{ $anggaran->id_rekening == $rekening->id_rekening ? 'selected' : '' }}>
                        {{ $rekening->nomor_rek }} - {{ $rekening->alokasi_rekening }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="tipe_anggaran" class="form-label">Tipe Anggaran</label>
            <input type="text" class="form-control" id="tipe_anggaran" name="tipe_anggaran" value="{{ old('tipe_anggaran', $anggaran->tipe_anggaran) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>
@endsection
