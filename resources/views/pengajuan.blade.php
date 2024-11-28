@extends('layouts.main')

@section('title', 'Pengajuan Anggaran')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Pengajuan Anggaran</h1>

    <!-- Menampilkan pesan sukses -->
    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tombol untuk tambah pengajuan baru -->
    <div class="mb-4">
        <button id="btnTambah" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Pengajuan Baru</button>
    </div>

    <!-- Form pengajuan anggaran (awalnya disembunyikan) -->
    <div id="formPengajuan" class="hidden mb-6">
        <h2 class="text-xl font-semibold">Form Pengajuan Anggaran</h2>
        <form action="{{ route('pengajuan.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="id_divisi" class="block text-sm font-medium text-gray-700">Divisi</label>

                <!-- Input untuk menampilkan nama divisi -->
                <input type="text" name="divisi_name" id="divisi_name" class="border rounded w-full py-2 px-3"
                    value="{{ auth()->user()->divisi->nama_divisi }}" readonly>

                <!-- Hidden input untuk mengirimkan id_divisi -->
                <input type="hidden" name="id_divisi" id="id_divisi" value="{{ auth()->user()->divisi->id_divisi }}">
            </div>

            <div class="mb-4">
                <label for="id_rekening" class="block text-sm font-medium text-gray-700">Rekening</label>
                <select name="id_rekening" id="id_rekening" class="border rounded w-full py-2 px-3">
                    @foreach($rekings as $rekening)
                        <option value="{{ $rekening->id_rekening }}">
                            {{ $rekening->nomor_rek }} - {{ $rekening->alokasi_rekening }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="id_anggaran" class="block text-sm font-medium text-gray-700">Anggaran</label>
                <select name="id_anggaran" id="id_anggaran" class="border rounded w-full py-2 px-3">
                    @foreach($anggarans as $anggaran)
                        <option value="{{ $anggaran->id_anggaran }}">{{ $anggaran->nama_anggaran }} (Rp
                            {{ number_format($anggaran->jumlah, 0, ',', '.') }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label for="nama_pengajuan" class="block text-sm font-medium text-gray-700">Nama Pengajuan</label>
                <input type="text" name="nama_pengajuan" id="nama_pengajuan" class="border rounded w-full py-2 px-3"
                    required>
            </div>

            <div class="mb-4">
                <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah Pengajuan</label>
                <input type="number" name="jumlah" id="jumlah" class="border rounded w-full py-2 px-3" required>
            </div>

            <div class="mb-4">
                <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal Pengajuan</label>
                <input type="date" name="tanggal" id="tanggal" class="border rounded w-full py-2 px-3" required>
            </div>

            <div>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Submit</button>
                <button type="button" id="btnBatal" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
            </div>
        </form>
    </div>

    <!-- Tabel Daftar Pengajuan -->
    <table id="pengajuanTable" class="table table-striped table-bordered mt-4 w-full">
        <thead class="bg-green-100 text-center align-middle">
            <tr>
                <th class="text-center">No</th>
                <th class="text-center">Nama Pengajuan</th>
                <th class="text-center">Divisi</th>
                <th class="text-center">Rekening</th>
                <th class="text-center">Jumlah</th>
                <th class="text-center">Sisa Saldo</th>
                <th class="text-center">Tanggal Pengajuan</th>
                <th class="text-center">Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php
                $saldoDivisi = $sisaSaldoDivisi;
            @endphp
            @foreach($pengajuans as $index => $pengajuan)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-left">{{ $pengajuan->nama_pengajuan }}</td>
                            <td class="text-left">{{ $pengajuan->divisi->nama_divisi }}</td>
                            <td class="text-left">
                                @if($pengajuan->rekening)
                                    {{ $pengajuan->rekening->nomor_rek }} - {{ $pengajuan->rekening->alokasi_rekening }}
                                @else
                                    Tidak ada rekening
                                @endif
                            </td>
                            <td class="text-right">{{ number_format($pengajuan->jumlah, 0, ',', '.') }}</td>
                            <td class="text-right">
                                @php
                                    $idDivisi = $pengajuan->id_divisi;
                                    $saldoDivisi[$idDivisi] -= $pengajuan->jumlah;
                                @endphp
                                {{ number_format($saldoDivisi[$idDivisi], 0, ',', '.') }}
                            </td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($pengajuan->tanggal)->format('d-m-Y') }}</td>
                            <td class="text-center">
                                @if($pengajuan->status)
                                    {{ $pengajuan->status }}
                                @else
                                    Pending
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-between">
                                    <!-- Tombol Edit -->
                                    <a href="{{ route('pengajuan.edit', $pengajuan->id_pengajuan) }}"
                                        class="btn btn-warning btn-sm me-2">Edit</a>
                                    <!-- Tombol Hapus -->
                                    <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#confirmDeleteModal"
                                        data-id="{{ $pengajuan->id_pengajuan }}">Hapus</button>
                                </div>
                            </td>
                        </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Konfirmasi Hapus -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menghapus pengajuan anggaran ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                <form method="POST" action="{{ route('pengajuan.destroy', '') }}" id="deleteForm"
                    style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<!-- Tambahkan library DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        // Inisialisasi DataTables
        $('#pengajuanTable').DataTable({
            paging: true,
            searching: true,
            ordering: true
        });

        // Tombol Tambah
        $('#btnTambah').on('click', function () {
            $('#formPengajuan').removeClass('hidden');
            $('#pengajuanTable').addClass('hidden');
        });

        // Tombol Batal
        $('#btnBatal').on('click', function () {
            $('#formPengajuan').addClass('hidden');
            $('#pengajuanTable').removeClass('hidden');
        });

        // Konfirmasi hapus
        $('#confirmDeleteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var action = '{{ route("pengajuan.destroy", "") }}/' + id;
            $('#deleteForm').attr('action', action);
        });
    });
</script>
@endsection
@endsection
