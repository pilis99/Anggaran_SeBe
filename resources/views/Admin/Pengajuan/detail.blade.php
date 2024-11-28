@extends('layouts.main')

@section('title', 'Detail Pengajuan Divisi')

@section('content')
<div class="bg-white p-4 rounded shadow">
    <h2 class="text-lg font-semibold mb-4">Daftar Pengajuan - Divisi {{ $division->nama_divisi }}</h2>
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
                                    // Menggunakan saldo divisi yang dikirim dari controller
                                    $saldoDivisi = $sisaSaldoDivisi;
                                    // Mengurangi saldo dengan jumlah pengajuan untuk setiap pengajuan
                                    $saldoDivisi -= $pengajuan->jumlah;
                                @endphp
                                {{ number_format($saldoDivisi, 0, ',', '.') }}
                            </td>

                            <td class="text-center">{{ \Carbon\Carbon::parse($pengajuan->tanggal)->format('d-m-Y') }}</td>
                            <td>
                                <select class="form-control status-select" data-id="{{ $pengajuan->id_divisi}}">
                                    <option value="pending" {{ $pengajuan->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $pengajuan->status == 'approved' ? 'selected' : '' }}>Approved
                                    </option>
                                    <option value="rejected" {{ $pengajuan->status == 'rejected' ? 'selected' : '' }}>Rejected
                                    </option>
                                </select>
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
@endsection

@section('scripts')
<script>
    // Update status pengajuan
    $('.status-select').on('change', function () {
        const id = $(this).data('id_divisi');
        const status = $(this).val();
        $.post('{{ route('admin.pengajuan.updateStatus') }}', {
            _token: '{{ csrf_token() }}',
            id: id,
            status: status
        }, function (response) {
            alert(response.message);
        });
    });
</script>
@endsection