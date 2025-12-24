<?php

use App\Http\Livewire\Kandidat;
use App\Http\Livewire\Kriteria;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Penilaian;
use App\Http\Livewire\WaspasProses;
use App\Http\Livewire\WaspasHasil;
use App\Http\Livewire\KriteriaNilai;
use App\Http\Livewire\Report;
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

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('profile', Profile::class)
    ->middleware(['auth'])
    ->name('profile');

    Route::middleware(['auth', 'menu.access'])->group(function () {

    // Route::get('/dashboard', Dashboard::class)
    //     ->name('dashboard');
    Route::get('/dashboard', \App\Http\Livewire\Dashboard::class)->name('dashboard');

    Route::get('/kandidat', Kandidat::class)
        ->name('kandidat.index');

    Route::get('/kriteria', Kriteria::class)
        ->name('kriteria.index');

    Route::get('/bidang-ilmu', \App\Http\Livewire\BidangIlmu::class)
        ->name('bidang-ilmu.index');

    Route::get('/syarat-jabatan', \App\Http\Livewire\SyaratJabatan::class)
        ->name('syarat-jabatan.index');

    Route::get('/jabatan-target', \App\Http\Livewire\JabatanTarget::class)
        ->name('jabatan-target.index');

    Route::get('/kriteria-nilai', KriteriaNilai::class)
        ->name('kriteria-nilai.index');

    Route::get('/penilaian', Penilaian::class)
        ->name('penilaian.input');

    Route::get('/waspas/proses', WaspasProses::class)
        ->name('waspas.proses');

    Route::get('/waspas/hasil', WaspasHasil::class)
        ->name('waspas.hasil');

});

// Report page - accessible only via direct URL (not in sidebar menu)
Route::middleware(['auth'])->group(function () {
    Route::get('/report', Report::class)
        ->name('report');
});


// Logout route
use App\Livewire\Actions\Logout;

Route::post('logout', function (Logout $logout) {
    $logout();
    return redirect('/login');
})->middleware('auth')->name('logout');

require __DIR__.'/auth.php';
