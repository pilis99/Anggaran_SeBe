<?php
use App\Anggaran;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\ManageDataController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AnggaranController;
use App\Http\Controllers\ManageUnitController;

Route::get('/', function () {
    return redirect()->route('login');
});


Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.custom');


Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/home/kadiv', [HomeController::class, 'homeKadiv'])->name('home.kadiv');
    Route::get('/home/admin', [HomeController::class, 'homeAdmin'])->name('home.admin');
});

// Route untuk kepala divisi
Route::middleware(['auth', 'Roles:kepala_divisi'])->group(function () {
    Route::get('/pengajuan', [PengajuanController::class, 'show'])->name('pengajuan.show');
    Route::get('/pengajuan/create', [PengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('/pengajuan/store', [PengajuanController::class, 'store'])->name('pengajuan.store');
    Route::delete('/pengajuan/{id}', [pengajuanController::class, 'destroy'])->name('pengajuan.destroy');
    Route::get('pengajuan/edit/{id}', [PengajuanController::class, 'edit'])->name('pengajuan.edit');
    Route::put('/pengajuan/{id}', [pengajuanController::class, 'update'])->name('pengajuan.update');
});

// Route untuk admin
Route::middleware(['auth', 'Roles:admin'])->group(function () {
    Route::get('/divisi', [PengajuanController::class, 'index'])->name('admin.pengajuan.index');
    Route::get('/divisi/{id}', [PengajuanController::class, 'detail'])->name('admin.pengajuan.detail');
    Route::post('/update-status', [PengajuanController::class, 'updateStatus'])->name('admin.pengajuan.updateStatus');
});


Route::middleware(['auth', 'Roles:kepala_divisi'])->group(function () {
    Route::get('/pengajuan', [PengajuanController::class, 'show'])->name('pengajuan.show');
    Route::get('/pengajuan/create', [PengajuanController::class, 'create'])->name('pengajuan.create');
    Route::post('/pengajuan/store', [PengajuanController::class, 'store'])->name('pengajuan.store');
    Route::delete('/pengajuan/{id}', [pengajuanController::class, 'destroy'])->name('pengajuan.destroy');
    Route::get('pengajuan/edit/{id}', [PengajuanController::class, 'edit'])->name('pengajuan.edit');
    Route::put('/pengajuan/{id}', [pengajuanController::class, 'update'])->name('pengajuan.update');
});

//KELOLA REKENING
Route::middleware(['auth', 'Roles:admin'])->group(function () {
    Route::get('/manage/data', [ManageDataController::class, 'index'])->name('manage.data');
    Route::get('/manage/data/rekening/create', [ManageDataController::class, 'createRekening'])->name('manage.data.rekening.create');
    Route::post('/manage/data/rekening/store', [ManageDataController::class, 'storeRekening'])->name('manage.data.rekening.store');
    Route::get('/manage/data/rekening/edit/{id}', [ManageDataController::class, 'editRekening'])->name('manage.data.rekening.edit');
    Route::delete('/manage/data/rekening/{id}', [ManageDataController::class, 'destroyRekening'])->name('manage.data.rekening.destroy');
    Route::put('/manage/data/rekening/update/{id}', [ManageDataController::class, 'updateRekening'])->name('manage.data.rekening.update');
});

// KELOLA UNIT
Route::middleware(['auth', 'Roles:admin'])->group(function () {
    Route::get('/manage/unit', [ManageUnitController::class, 'index'])->name('manage.unit'); // Menampilkan daftar unit
    Route::get('/manage/unit/create', [ManageUnitController::class, 'create'])->name('manage.unit.create'); // Menampilkan form tambah unit
    Route::post('/manage/unit/store', [ManageUnitController::class, 'store'])->name('manage.unit.store'); // Menyimpan data unit baru
    Route::get('/manage/unit/edit/{id}', [ManageUnitController::class, 'edit'])->name('manage.unit.edit'); // Menampilkan form edit unit
    Route::delete('/manage/unit/{id}', [ManageUnitController::class, 'destroy'])->name('manage.unit.destroy'); // Menghapus unit
    Route::put('/manage/unit/update/{id}', [ManageUnitController::class, 'update'])->name('manage.unit.update'); // Memperbarui data unit
});


//KELOLA USER
Route::middleware(['auth', 'Roles:admin'])->group(function () {
    Route::get('/manage/user', [RegisterController::class, 'index'])->name('manage.user'); // Menampilkan daftar pengguna
    Route::get('/manage/user/create', [RegisterController::class, 'showRegistrationForm'])->name('manage.user.create'); // Menampilkan form pendaftaran pengguna baru
    Route::get('/manage/user/edit/{id}', [RegisterController::class, 'editUser'])->name('manage.user.edit');
    Route::delete('/manage/user/{id}', [RegisterController::class, 'destroy'])->name('manage.user.destroy'); // Menghapus pengguna
    Route::post('/manage/user/store', [RegisterController::class, 'store'])->name('manage.user.store'); // Menyimpan pengguna baru
    Route::put('/manage/user/{id}', [RegisterController::class, 'update'])->name('manage.user.update'); // Memperbarui pengguna
});


Route::middleware(['auth', 'Roles:kepala_divisi'])->group(function () {
    Route::get('/manage/data/anggaran', [AnggaranController::class, 'index'])->name('manage.data.anggaran');
    Route::get('/manage/data/anggaran/create', [AnggaranController::class, 'create'])->name('manage.data.anggaran.create');
    Route::post('/manage/data/anggaran/store', [AnggaranController::class, 'store'])->name('manage.data.anggaran.store');
    Route::get('manage/data/anggaran/{id}/edit', [AnggaranController::class, 'edit'])->name('manage.data.anggaran.edit');
    Route::put('manage/data/anggaran/{id}', [AnggaranController::class, 'update'])->name('manage.data.anggaran.update');
    Route::delete('manage/data/anggaran/{id}', [AnggaranController::class, 'destroy'])->name('manage.data.anggaran.destroy');
});
