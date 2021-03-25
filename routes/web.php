<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Http\Request;

Route::get('mahasiswas/search', [MahasiswaController::class, 'search'])->name('mahasiswas.search');
Route::resource('mahasiswas', MahasiswaController::class);

Route::get('/', function () {
    return view('welcome');
});
