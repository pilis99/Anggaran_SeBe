@extends('layouts.main')

@section('title', 'Kelola Divisi')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Kelola Divisi</h1>

    @if(session('success'))
        <div class="bg-green-500 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-4">
        <a href="{{ route('manage.unit.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah Divisi</a>
    </div>

    <h2 class="text-xl font-semibold mt-6">Daftar Divisi</h2>
    <table id="divisiTable" class="table table-striped table-bordered mt-4">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Divisi</th>
                <th>Nama Divisi</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($divisis as $index => $divisi)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $divisi->id_divisi }}</td>
                    <td>{{ $divisi->nama_divisi }}</td>
                    <td>
                        <a href="{{ route('manage.unit.edit', $divisi->id_divisi) }}" class="btn btn-warning btn-edit">Edit</a>
                        <button class="btn btn-danger btn-delete" data-toggle="modal" data-target="#confirmDeleteModal" data-id="{{ $divisi->id_divisi }}">Hapus</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus divisi ini?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" action="" style="display: inline;">
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
    $(document).ready(function() {
        // Inisialisasi DataTable
        $('#divisiTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: true,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/Indonesian.json'
            }
        });

        // Menangani klik tombol hapus
        $('.btn-delete').on('click', function() {
            var divisiId = $(this).data('id');
            var actionUrl = '{{ route("manage.unit.destroy", ":id") }}';
            actionUrl = actionUrl.replace(':id', divisiId);
            $('#deleteForm').attr('action', actionUrl);
        });
    });
</script>
@endsection
@endsection
