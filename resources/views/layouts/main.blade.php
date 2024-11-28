<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>@yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />

    <!-- Tambahkan di dalam tag <head> di layout utama -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <!-- Jika menggunakan Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-gray-100 font-roboto">
    <div class="flex">
        <!-- Sidebar -->
        <div class="w-1/6 bg-white h-screen p-4 shadow-lg">
            <div class="flex items-center mb-8">
                <img alt="Company Logo" class="mr-2" height="50" src="{{ asset('images/logo.png') }}" width="150" />
            </div>
            <ul class="space-y-2"> <!-- Tambahkan space-y untuk jarak antar item -->
                <li
                    class="flex items-center p-2 rounded {{ request()->routeIs('home.kadiv') ? 'bg-green-200 text-green-600' : 'hover:bg-gray-100' }}">
                    <i class="fas fa-home w-6 text-center"></i> <!-- Lebar ikon seragam -->
                    <a class="ml-3 w-full"
                        href="{{ auth()->user()->role == 'admin' ? route('home.admin') : route('home.kadiv') }}">Halaman
                        Utama</a>
                </li>
                @if(auth()->user()->role == 'admin') <!-- Pengecekan untuk admin -->
                    <li
                        class="flex items-center p-2 rounded {{ request()->routeIs('manage.data') ? 'bg-green-200 text-green-600' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-database w-6 text-center"></i>
                        <a class="ml-3 w-full" href="{{ route('manage.data') }}">Kelola Rekening</a>
                    </li>
                    <li
                        class="flex items-center p-2 rounded {{ request()->routeIs('manage.unit') ? 'bg-green-200 text-green-600' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-users w-6 text-center"></i>
                        <a class="ml-3 w-full" href="{{ route('manage.unit') }}">Kelola Unit</a>
                    </li>
                    <li
                        class="flex items-center p-2 rounded {{ request()->routeIs('manage.user') ? 'bg-green-200 text-green-600' : 'hover:bg-gray-100' }}">
                        <i class="fas fa-user-circle w-6 text-center"></i>
                        <a class="ml-3 w-full" href="{{ route('manage.user') }}">Kelola User</a>
                    </li>
                @endif
                <li
                    class="flex items-center p-2 rounded {{ request()->routeIs('pengajuan.show') ? 'bg-green-200 text-green-600' : 'hover:bg-gray-100' }}">
                    <i class="fas fa-file-alt w-6 text-center"></i>
                    <a class="ml-3 w-full"
                        href="{{ auth()->user()->role == 'admin' ? route('admin.pengajuan.index') : route('pengajuan.show') }}">Pengajuan</a>
                </li>
                <li
                    class="flex items-center p-2 rounded {{ request()->routeIs('manage.data.anggaran') ? 'bg-green-200 text-green-600' : 'hover:bg-gray-100' }}">
                    <i class="fas fa-money-bill-alt w-6 text-center"></i>
                    <a class="ml-3 w-full" href="{{ route('manage.data.anggaran') }}">Anggaran</a>
                </li>
                <li
                    class="flex items-center p-2 rounded {{ request()->routeIs('realisasi') ? 'bg-green-200 text-green-600' : 'hover:bg-gray-100' }}">
                    <i class="fas fa-check-circle w-6 text-center"></i>
                    <a class="ml-3 w-full" href="#">Realisasi</a>
                </li>
                <li
                    class="flex items-center p-2 rounded {{ request()->routeIs('dokumen.anggaran') ? 'bg-green-200 text-green-600' : 'hover:bg-gray-100' }}">
                    <i class="fas fa-folder-open w-6 text-center"></i>
                    <a class="ml-3 w-full" href="#">Dokumen Anggaran</a>
                </li>
                <li
                    class="flex items-center p-2 rounded {{ request()->routeIs('report') ? 'bg-green-200 text-green-600' : 'hover:bg-gray-100' }}">
                    <i class="fas fa-file w-6 text-center"></i>
                    <a class="ml-3 w-full" href="#">Report</a>
                </li>
                <li
                    class="flex items-center p-2 rounded {{ request()->routeIs('setting') ? 'bg-green-200 text-green-600' : 'hover:bg-gray-100' }}">
                    <i class="fas fa-cog w-6 text-center"></i>
                    <a class="ml-3 w-full" href="#">Setting</a>
                </li>
            </ul>
        </div>

        <!-- Main Content -->
        <div class="w-5/6 p-8">
            <div class="flex justify-between items-center mb-8">
                <form method="GET" action="{{ route(Route::currentRouteName()) }}">
                    <!-- Dropdown Tahun -->
                    <select name="tahun" class="border rounded-full px-4 py-2 mr-4" onchange="this.form.submit()">
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                {{ $year }}
                            </option>
                        @endforeach
                    </select>


                </form>

                <!-- Dropdown Profil -->
                <div class="relative">
                    <button id="profileDropdownButton"
                        class="flex items-center text-gray-700 bg-gray-100 p-2 rounded-md shadow hover:bg-gray-200">
                        <i class="fas fa-user-circle text-2xl mr-2"></i>
                        <span>{{ auth()->user()->role == 'kepala_divisi' ? 'KADIV ' . strtoupper(auth()->user()->department) : 'ADMIN' }}</span>
                        <i class="fas fa-caret-down ml-2"></i>
                    </button>
                    <div id="profileDropdownMenu"
                        class="absolute right-0 mt-2 w-40 bg-white shadow-md rounded-lg hidden">
                        <ul class="text-gray-700">
                            <li class="hover:bg-gray-100">
                                <a href="#" class="block px-4 py-2 text-sm">Profile</a>
                            </li>
                            <li class="hover:bg-gray-100">
                                <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @yield('content')
        </div>
    </div>

    <!-- Tambahkan di bawah jQuery sebelum penutup </body> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <!-- Jika menggunakan Bootstrap -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('profileDropdownButton').addEventListener('click', function () {
            const dropdownMenu = document.getElementById('profileDropdownMenu');
            dropdownMenu.classList.toggle('hidden');
        });

        // Close dropdown if clicked outside
        window.addEventListener('click', function (e) {
            const button = document.getElementById('profileDropdownButton');
            const menu = document.getElementById('profileDropdownMenu');
            if (!button.contains(e.target) && !menu.contains(e.target)) {
                menu.classList.add('hidden');
            }
        });
    </script>
    @yield('scripts') <!-- Menyertakan skrip tambahan jika ada -->
</body>

</html>