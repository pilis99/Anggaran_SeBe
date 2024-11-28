@extends('layouts.main')

@section('title', 'Daftar Anggaran')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Daftar Anggaran</h1>

    <!-- Kotak Saldo/Balance Anggaran -->
    <div class="mb-4 p-3 bg-light text-dark text-center rounded">
        <h2 class="text-xl font-semibold">Saldo Anggaran:
            <span class="text-primary">Rp {{ number_format($totalSaldo, 0, ',', '.') }}</span>
        </h2>
    </div>

    <!-- Tombol Tambah Anggaran Baru -->
    <div class="mb-4">
        <a href="{{ route('manage.data.anggaran.create') }}" class="btn btn-primary">
            Tambah Anggaran Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Tabel Daftar Anggaran -->
    <div class="table-responsive">
        <table id="anggaranTable" class="table table-striped table-hover align-middle">
            <thead class="table-success">
                <tr>
                    <th class="text-center">No</th>
                    <th class="text-center">Nama Anggaran</th>
                    <th class="text-center">Debit</th> <!-- Kolom Debit -->
                    <th class="text-center">Kredit</th> <!-- Kolom Kredit -->
                    <th class="text-center">Tanggal</th>
                    <th class="text-center">Divisi</th>
                    <th class="text-center">Rekening</th>
                    <!-- <th class="text-center">Tahun</th> -->
                    <th class="text-center">Tipe Anggaran</th> <!-- Kolom untuk Tipe Anggaran -->
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($anggarans as $index => $anggaran)

                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $anggaran->nama_anggaran }}</td>
                        <td>
                            @if($anggaran->tipe_anggaran == 'Penerimaan')
                                {{ number_format($anggaran->jumlah, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($anggaran->tipe_anggaran == 'Pengeluaran')
                                {{ number_format($anggaran->jumlah, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ \Carbon\Carbon::parse($anggaran->tanggal)->format('d-m-Y') }}</td>
                        <td>{{ $anggaran->divisi->nama_divisi }}</td>
                        <td>
                            @if($anggaran->rekening)
                                {{ $anggaran->rekening->nomor_rek }} - {{ $anggaran->rekening->alokasi_rekening }}
                            @else
                                Tidak ada rekening
                            @endif
                        </td>
                        <!-- <td>{{ \Carbon\Carbon::parse($anggaran->tanggal)->format('Y') }}</td> -->
                        <td>{{ $anggaran->tipe_anggaran }}</td> <!-- Menampilkan tipe anggaran -->
                        <td>
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('manage.data.anggaran.edit', $anggaran->id_anggaran) }}"
                                    class="btn btn-warning btn-sm me-2">Edit</a>
                                <button class="btn btn-danger btn-delete" data-toggle="modal"
                                    data-target="#confirmDeleteModal" data-id="{{ $anggaran->id_anggaran }}">Hapus</button>
                            </div>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmDeleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus anggaran ini?
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
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function () {
        $('#anggaranTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            lengthChange: true,
            responsive: true,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/Indonesian.json'
            }
        });

        $('.btn-delete').on('click', function () {
            var anggaranId = $(this).data('id');
            var actionUrl = '{{ route("manage.data.anggaran.destroy", ":id") }}';
            actionUrl = actionUrl.replace(':id', anggaranId);
            $('#deleteForm').attr('action', actionUrl);
        });


    });
</script>
@endsection
@endsection