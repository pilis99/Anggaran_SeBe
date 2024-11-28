@extends('layouts.main')

@section('title', 'Kelola User')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Kelola User</h1>

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
        <a href="{{ route('manage.user.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Tambah User</a>
    </div>

    <h2 class="text-xl font-semibold mt-6">Daftar Pengguna</h2>
    <table id="userTable" class="table table-striped table-bordered mt-4">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama User</th>
                <th>Email</th>
                <th>Role</th>
                <th>Divisi</th> <!-- Menambahkan kolom Divisi -->
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $user->nama_user }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->role == 'admin')
                            Admin
                        @elseif($user->role == 'kepala_divisi')
                            Kepala Divisi
                        @else
                            {{ $user->role }}
                        @endif
                    </td>

                    <td>
                        <!-- Menampilkan Divisi hanya jika role bukan 'admin' -->
                        @if($user->role != 'admin')
                            {{ $user->divisi->nama_divisi ?? '-' }} <!-- Menampilkan nama divisi, atau '-' jika tidak ada -->
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('manage.user.edit', $user->id_user) }}" class="btn btn-warning btn-edit">Edit</a>
                        <button class="btn btn-danger btn-delete" data-toggle="modal" data-target="#confirmDeleteModal"
                            data-id="{{ $user->id_user }}">Hapus</button>
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
                    Apakah Anda yakin ingin menghapus pengguna ini?
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
    $(document).ready(function () {
        // Inisialisasi DataTable
        $('#userTable').DataTable({
            paging: true, // Mengaktifkan pagination
            searching: true, // Mengaktifkan pencarian
            ordering: true, // Mengaktifkan pengurutan
            info: true, // Menampilkan informasi
            lengthChange: true, // Mengizinkan pengguna untuk mengubah jumlah baris yang ditampilkan
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/Indonesian.json' // Menggunakan bahasa Indonesia
            }
        });

        // Menangani klik tombol hapus
        $('.btn-delete').on('click', function () {
            var userId = $(this).data('id');
            var actionUrl = '{{ route("manage.user.destroy", ":id") }}';
            actionUrl = actionUrl.replace(':id', userId);
            $('#deleteForm').attr('action', actionUrl);
        });
    });
</script>
@endsection
@endsection
