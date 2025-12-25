<?php

use App\Http\Livewire\Kandidat;
use App\Http\Livewire\Kriteria;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Penilaian;
use App\Http\Livewire\WaspasProses;
use App\Http\Livewire\WaspasHasil;
use App\Http\Livewire\KriteriaNilai;
use App\Http\Livewire\HasilAkhir;
use App\Http\Livewire\Profile;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('profile', Profile::class)
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth', 'menu.access'])->group(function () {
    // Dashboard - accessible by all roles
    Route::get('/dashboard', \App\Http\Livewire\Dashboard::class)->name('dashboard');

    Route::get('/kandidat', Kandidat::class)
        ->name('kandidat.index');

    Route::get('/kandidat/input-nilai', \App\Http\Livewire\InputNilaiKandidat::class)
        ->name('kandidat.input-nilai');

    Route::get('/kriteria', Kriteria::class)
        ->name('kriteria.index');

    Route::get('/bidang-ilmu', \App\Http\Livewire\BidangIlmu::class)
        ->name('bidang-ilmu.index');

    Route::get('/syarat-jabatan', \App\Http\Livewire\SyaratJabatan::class)
        ->name('syarat-jabatan.index');

    Route::get('/jabatan-target', \App\Http\Livewire\JabatanTarget::class)
        ->name('jabatan-target.index');

    Route::get('/jabatan-pelaksana', \App\Http\Livewire\JabatanPelaksana::class)
        ->name('jabatan-pelaksana.index');

    Route::get('/jabatan-fungsional', \App\Http\Livewire\JabatanFungsional::class)
        ->name('jabatan-fungsional.index');

    Route::get('/golongan', \App\Http\Livewire\Golongan::class)
        ->name('golongan.index');

    Route::get('/unit-kerja', \App\Http\Livewire\UnitKerja::class)
        ->name('unit-kerja.index');

    Route::get('/kriteria-nilai', KriteriaNilai::class)
        ->name('kriteria-nilai.index');

    Route::get('/penilaian', Penilaian::class)
        ->name('penilaian.input');

    Route::get('/waspas/proses', WaspasProses::class)
        ->name('waspas.proses');

    Route::get('/waspas/hasil', WaspasHasil::class)
        ->name('waspas.hasil');

    // Manajemen (Super Admin only by menu & logic, but protected here too)
    Route::get('/manajemen/users', \App\Http\Livewire\UserManager::class)
        ->name('users.index');
    Route::get('/manajemen/roles', \App\Http\Livewire\RoleManager::class)
        ->name('roles.index');

});

// Hasil Akhir page (formerly Laporan)
Route::middleware(['auth'])->group(function () {
    Route::get('/hasil-akhir', HasilAkhir::class)
        ->name('hasil-akhir');
    Route::get('/hasil-akhir/pdf', [\App\Http\Controllers\ReportController::class, 'downloadHasilAkhir'])
        ->name('hasil-akhir.pdf');
});


// Logout route
use App\Livewire\Actions\Logout;

Route::post('logout', function (Logout $logout) {
    $logout();
    return redirect('/login');
})->middleware('auth')->name('logout');

require __DIR__.'/auth.php';
