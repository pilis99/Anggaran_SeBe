@extends('layouts.main')

@section('title', 'Pengajuan Admin')

@section('content')
<div class="bg-white p-4 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">Daftar Divisi yang Mengajukan Anggaran</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Divisi</th>
                <th>Jumlah Pengajuan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($divisions as $key => $division)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $division->nama_divisi }}</td>
                    <td>{{ $division->pengajuan_count }}</td>
                    <td>
                        <a href="{{ route('admin.pengajuan.detail', $division->id_divisi) }}"
                            class="btn btn-primary">Detail</a>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection