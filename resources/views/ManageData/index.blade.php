@extends('layouts.main')

@section('title', 'Manage Data')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Manage Data</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('manage.data.rekening.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah
            Rekening</a>
    </div>

    <!-- Tampilkan daftar rekening jika ada -->
    <h2 class="text-xl font-semibold mt-6">Daftar Rekening</h2>
    <table id="rekeningTable" class="table table-striped table-bordered mt-4">
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Rekening</th>
                <th>Alokasi Rekening</th>
                <th>Jenis Rekening</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rekings as $index => $rekening)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $rekening->nomor_rek }}</td>
                    <td>{{ $rekening->alokasi_rekening }}</td>
                    <td>{{ getJenisRekening($rekening->jenis_rek) }}</td>
                    <td>
                        <a href="{{ route('manage.data.rekening.edit', $rekening->id_rekening) }}"
                            class="btn btn-warning btn-edit">Edit</a>
                        <button class="btn btn-danger btn-delete" data-toggle="modal" data-target="#confirmDeleteModal"
                            data-id="{{ $rekening->id_rekening }}">Hapus</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog"
        aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus rekening ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <form method="POST" action="" id="deleteForm" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script>
    $(document).ready(function () {
        // Inisialisasi DataTable
        $('#rekeningTable').DataTable({
            // Konfigurasi DataTable
            searching: true, // Enable search
            paging: true, // Enable pagination
            ordering: true, // Enable ordering (sorting)
            lengthChange: true, // Enable length change
        });


        // Ketika tombol hapus diklik
        $('.btn-delete').on('click', function () {
            var rekeningId = $(this).data('id'); // Ambil ID rekening
            var deleteUrl = '{{ route("manage.data.rekening.destroy", ":id") }}'; // Route untuk menghapus rekening
            deleteUrl = deleteUrl.replace(':id', rekeningId); // Ganti :id dengan ID rekening
            $('#deleteForm').attr('action', deleteUrl); // Set action form dengan URL yang benar
        });
    });
</script>
@endsection
@endsection

@php
    // Fungsi untuk mendapatkan keterangan jenis rekening
    function getJenisRekening($jenis)
    {
        $jenisRekening = [
            '1' => 'Kas Bon',
            '2' => 'Penerimaan',
            '3' => 'Pengeluaran',
            '4' => 'Pengeluaran Inventaris',
            // Tambahkan jenis rekening lain sesuai kebutuhan
        ];

        return $jenisRekening[$jenis] ?? 'Tidak Diketahui'; // Mengembalikan 'Tidak Diketahui' jika jenis tidak ada
    }
@endphp