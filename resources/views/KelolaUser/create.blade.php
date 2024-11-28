@extends('layouts.main')

@section('title', 'Tambah User')

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Tambah User</h1>

    <form action="{{ route('manage.user.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="nama_user" class="block text-sm font-medium text-gray-700">Nama User</label>
            <input type="text" name="nama_user" id="nama_user" class="border rounded w-full py-2 px-3" required>
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" id="email" class="border rounded w-full py-2 px-3" required>
        </div>

        <div class="mb-4">
            <label for="role" class="block text-sm font-medium text-gray-700">Role</label>
            <select name="role" id="role" class="border rounded w-full py-2 px-3" required>
                <option value="admin">Admin</option>
                <option value="kepala_divisi">Kepala Divisi</option>
            </select>
        </div>

        <!-- Kolom id_divisi hanya muncul jika role adalah kepala_divisi -->
        <div class="mb-4" id="divisi_field" style="display: none;">
            <label for="id_divisi" class="block text-sm font-medium text-gray-700">Divisi</label>
            <select name="id_divisi" id="id_divisi" class="border rounded w-full py-2 px-3">
                @foreach ($divisis as $divisi)
                    <option value="{{ $divisi->id_divisi }}">{{ $divisi->id_divisi }} - {{ $divisi->nama_divisi }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4 relative">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" id="password" class="border rounded w-full py-2 px-3 pr-10" required>
            <i id="eye-icon"
                class="fas fa-eye absolute top-1/2 right-3 transform -translate-y-1/2 cursor-pointer text-gray-500"
                onclick="togglePasswordVisibility()"></i>
        </div>

        <div class="mb-4 relative">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi
                Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                class="border rounded w-full py-2 px-3 pr-10" required>
            <!-- Icon mata untuk melihat password konfirmasi -->
            <i id="eye-icon-confirm"
                class="fas fa-eye absolute top-1/2 right-3 transform -translate-y-1/2 cursor-pointer text-gray-500"
                onclick="togglePasswordVisibilityConfirm()"></i>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
        <a href="{{ route('manage.user') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
    </form>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

<script>
    document.getElementById('email').addEventListener('keyup', function (event) {
        const emailField = this;

        // Cek jika tombol '@' yang ditekan
        if (event.key === '@') {
            // Jika email belum mengandung domain
            if (!emailField.value.includes('@sebe.co.id')) {
                emailField.value += 'sebe.co.id';
            }
        }
    });
    // Menampilkan / Menyembunyikan dropdown id_divisi berdasarkan role yang dipilih
    document.getElementById('role').addEventListener('change', function () {
        const divisiField = document.getElementById('divisi_field');
        if (this.value === 'kepala_divisi') {
            divisiField.style.display = 'block';
        } else {
            divisiField.style.display = 'none';
        }
    });

    // Script untuk toggle visibility password
    function togglePasswordVisibility() {
        const passwordField = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }

    // Script untuk toggle visibility password konfirmasi
    function togglePasswordVisibilityConfirm() {
        const passwordFieldConfirm = document.getElementById('password_confirmation');
        const eyeIconConfirm = document.getElementById('eye-icon-confirm');
        if (passwordFieldConfirm.type === 'password') {
            passwordFieldConfirm.type = 'text';
            eyeIconConfirm.classList.remove('fa-eye');
            eyeIconConfirm.classList.add('fa-eye-slash');
        } else {
            passwordFieldConfirm.type = 'password';
            eyeIconConfirm.classList.remove('fa-eye-slash');
            eyeIconConfirm.classList.add('fa-eye');
        }
    }
</script>
@endsection