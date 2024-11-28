@extends('layouts.main')

@section('title', 'Edit Rekening')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Edit Rekening</h1>
    @if ($errors->any())
    <div class="bg-red-500 text-white p-4 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    
    <form action="{{ route('manage.data.rekening.update', $rekening->id_rekening) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="jenis_rek" class="block text-sm font-medium text-gray-700">Jenis Rekening</label>
            <select name="jenis_rek" id="jenis_rek" class="border rounded w-full py-2 px-3" required onchange="updateNomorRek()">
                <option value="">Pilih Jenis Rekening</option>
                <option value="1" {{ $rekening->jenis_rek == '1' ? 'selected' : '' }}>1 - Kas Bon</option>
                <option value="2" {{ $rekening->jenis_rek == '2' ? 'selected' : '' }}>2 - Penerimaan</option>
                <option value="3" {{ $rekening->jenis_rek == '3' ? 'selected' : '' }}>3 - Pengeluaran</option>
                <option value="4" {{ $rekening->jenis_rek == '4' ? 'selected' : '' }}>4 - Pengeluaran Inventaris</option>
            </select>
        </div>

        <div class="mb-4">
            <label for="nomor_rek" class="block text-sm font-medium text-gray-700">Nomor Rekening</label>
            <input type="text" name="nomor_rek" id="nomor_rek" class="border rounded w-full py-2 px-3" value="{{ old('nomor_rek', $rekening->nomor_rek) }}" required maxlength="5" placeholder="XXXX" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
        </div>

        <div class="mb-4">
            <label for="alokasi_rekening" class="block text-sm font-medium text-gray-700">Alokasi Rekening</label>
            <input type="text" name="alokasi_rekening" id="alokasi_rekening" class="border rounded w-full py-2 px-3" value="{{ $rekening->alokasi_rekening }}" required>
        </div>

        <div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
            <a href="{{ route('manage.data') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
        </div>
    </form>
</div>

@section('scripts')
<script>
    function updateNomorRek() {
        const jenisRek = document.getElementById('jenis_rek').value;
        const nomorRekInput = document.getElementById('nomor_rek');

        // Jika jenis rekening dipilih, set nomor rekening dengan prefix jenis rekening
        if (jenisRek) {
            nomorRekInput.value = jenisRek + nomorRekInput.value.slice(1, 5); // Pastikan angka pertama sesuai jenis rekening
            nomorRekInput.setAttribute('maxlength', '5'); // Set maxlength untuk 5 digit
            nomorRekInput.setAttribute('placeholder', jenisRek + 'XXX'); // Set placeholder dengan angka jenis rekening
        } else {
            nomorRekInput.value = ''; // Kosongkan jika tidak ada pilihan
        }
    }

    // Mengizinkan input untuk 4 digit setelah angka pertama
    document.getElementById('nomor_rek').addEventListener('input', function() {
        const jenisRek = document.getElementById('jenis_rek').value;
        if (jenisRek) {
            this.value = jenisRek + this.value.slice(1, 5); // Pastikan angka pertama tetap sesuai dengan jenis rekening
        }
    });

    // Panggil fungsi updateNomorRek saat halaman dimuat untuk mengatur nomor rekening awal
    document.addEventListener('DOMContentLoaded', function() {
        updateNomorRek();
    });
</script>
@endsection
@endsection
