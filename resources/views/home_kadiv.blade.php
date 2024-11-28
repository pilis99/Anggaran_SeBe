@extends('layouts.main')

@section('title', 'Home Kepala Divisi')

@section('content')
<div class="flex justify-between items-center mb-8">
    <h1 class="text-3xl font-bold">HALO, {{ auth()->user()->nama_user }}!</h1>
    
</div>

<div class="grid grid-cols-3 gap-4 mb-8">
    <div class="bg-gray-200 p-4 rounded-lg shadow-md">
        <div class="flex items-center mb-4">
            <i class="fas fa-check-circle text-2xl text-green-600 mr-2"></i>
            <span class="text-lg font-bold">Approved</span>
        </div>
        <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
    </div>
    <div class="bg-gray-200 p-4 rounded-lg shadow-md">
        <div class="flex items-center mb-4">
            <i class="fas fa-clock text-2xl text-purple-600 mr-2"></i>
            <span class="text-lg font-bold">Pending Approval</span>
        </div>
        <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
    </div>
    <div class="bg-gray-200 p-4 rounded-lg shadow-md">
        <div class="flex items-center mb-4">
            <i class="fas fa-times-circle text-2xl text-red-600 mr-2"></i>
            <span class="text-lg font-bold">Rejected</span>
        </div>
        <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
    </div>
</div>

<!-- Content for budget balance, budget realization, etc. -->
<div class="grid grid-cols-2 gap-4">
    <div class="bg-gray-200 p-4 rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-4">Budget Balance</h2>
        <p class="text-3xl font-bold mb-4">Rp 12.003.023</p>
        <div class="flex justify-between">
            <button class="bg-white px-4 py-2 rounded-full shadow-md">
                Rp 10.000.000
                <br/> Jumlah sisa
            </button>
            <button class="bg-white px-4 py-2 rounded-full shadow-md">
                Rp 5.000.000
                <br/> Visualisasi
            </button>
        </div>
    </div>
    <div class="bg-gray-200 p-4 rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-4">Budget Realization</h2>
        <img alt="Bar chart showing budget realization" height="200" src="{{ asset('images/chart.png') }}" width="300"/>
    </div>
</div>

<!-- Anggaran VS Realisasi -->
<div class="mt-8 bg-gray-200 p-4 rounded-lg shadow-md">
    <h2 class="text-xl font-bold mb-4">Anggaran VS Realisasi</h2>
    <img alt="Pie chart showing budget vs realization" height="400" src="{{ asset('images/pie-chart.png') }}" width="400"/>
</div>

@endsection

@section('scripts')
<script>
    // Menampilkan dan menyembunyikan dropdown
    document.getElementById('dropdown-toggle').addEventListener('click', function() {
        const dropdownMenu = document.getElementById('dropdown-menu');
        dropdownMenu.classList.toggle('hidden');
    });

    // Menutup dropdown saat mengklik di luar dropdown
    document.addEventListener('click', function(event) {
        const dropdownMenu = document.getElementById('dropdown-menu');
        if (!dropdownMenu.contains(event.target) && !document.getElementById('dropdown-toggle').contains(event.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });
</script>
@endsection
