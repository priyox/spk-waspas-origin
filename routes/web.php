<?php

use App\Http\Livewire\Kandidat;
use App\Http\Livewire\Kriteria;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Penilaian;
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

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

    Route::middleware(['auth', 'menu.access'])->group(function () {

    Route::get('/dashboard', Dashboard::class)
        ->name('dashboard');

    Route::get('/kandidat', [Kandidat::class, 'index'])
        ->name('kandidat.index');

    Route::get('/kriteria', [Kriteria::class, 'index'])
        ->name('kriteria.index');

    Route::get('/penilaian', [Penilaian::class, 'index'])
        ->name('penilaian.input');

    Route::get('/waspas/proses', [Waspas::class, 'proses'])
        ->name('waspas.proses');

    Route::get('/waspas/hasil', [Waspas::class, 'hasil'])
        ->name('waspas.hasil');

});


require __DIR__.'/auth.php';
