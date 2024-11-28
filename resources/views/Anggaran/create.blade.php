@extends('layouts.main')

@section('title', 'Tambah Anggaran')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Tambah Anggaran</h1>

    <form action="{{ route('manage.data.anggaran.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="nama_anggaran" class="block text-sm font-medium text-gray-700">Nama Anggaran</label>
            <input type="text" name="nama_anggaran" id="nama_anggaran" class="border rounded w-full py-2 px-3" required>
        </div>

        <div class="mb-4">
            <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah Anggaran</label>
            <input type="number" name="jumlah" id="jumlah" class="border rounded w-full py-2 px-3" required>
        </div>

        <div class="mb-4">
            <label for="id_rekening" class="block text-sm font-medium text-gray-700">Rekening</label>
            <select name="id_rekening" id="id_rekening" class="border rounded w-full py-2 px-3" required>
                @foreach($rekings as $rekening)
                    <option value="{{ $rekening->id_rekening }}" data-nomor="{{ $rekening->nomor_rek }}">
                        {{ $rekening->nomor_rek }} - {{ $rekening->alokasi_rekening }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="tanggal" class="block text-sm font-medium text-gray-700">Tanggal Anggaran</label>
            <input type="date" name="tanggal" id="tanggal" class="border rounded w-full py-2 px-3" required>
        </div>

        <div class="mb-4">
            <label for="id_divisi" class="block text-sm font-medium text-gray-700">Divisi</label>

            <!-- Input untuk menampilkan nama divisi -->
            <input type="text" name="divisi_name" id="divisi_name" class="border rounded w-full py-2 px-3"
                value="{{ auth()->user()->divisi->nama_divisi }}" readonly>

            <!-- Hidden input untuk mengirimkan id_divisi -->
            <input type="hidden" name="id_divisi" id="id_divisi" value="{{ auth()->user()->divisi->id_divisi }}">
        </div>

        <!-- Tambahkan input untuk tipe_transaksi (textbox yang tidak bisa diedit) -->
        <div class="mb-4">
            <label for="tipe_anggaran" class="block text-sm font-medium text-gray-700">Tipe Anggaran</label>
            <input type="text" name="tipe_anggaran" id="tipe_anggaran"
                class="border rounded w-full py-2 px-3 bg-gray-200" readonly>
        </div>


        <div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('manage.data.anggaran') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
        </div>
    </form>
</div>

@section('scripts')
<script>
    // Menentukan tipe transaksi berdasarkan rekening yang dipilih
    document.addEventListener('DOMContentLoaded', function () {
        const rekeningSelect = document.getElementById('id_rekening');
        const tipeAnggaranInput = document.getElementById('tipe_anggaran');

        rekeningSelect.addEventListener('change', function () {
            const selectedOption = rekeningSelect.options[rekeningSelect.selectedIndex];
            const rekeningNomor = selectedOption.getAttribute('data-nomor');

            // Menentukan tipe anggaran sesuai dengan nomor rekening
            if (rekeningNomor && rekeningNomor.startsWith('2')) {
                tipeAnggaranInput.value = 'Penerimaan';
            } else {
                tipeAnggaranInput.value = 'Pengeluaran';
            }
        });

        // Setel otomatis tipe anggaran saat halaman dimuat pertama kali
        rekeningSelect.dispatchEvent(new Event('change'));
    });

</script>
@endsection

@endsection
