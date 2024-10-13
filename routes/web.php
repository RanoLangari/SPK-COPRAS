<?php

use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\SubKriteriaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\IsOperator;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'home']);
    Route::get('/alternatif', [AlternatifController::class, 'index']);
    Route::post('alternatif/store', [AlternatifController::class, 'store'])->name('alternatif.store')->middleware(IsOperator::class);
    Route::put('alternatif/update/{alternatif}', [AlternatifController::class, 'update'])->name('alternatif.update')->middleware(IsOperator::class);
    Route::delete('alternatif/delete/{id}', [AlternatifController::class, 'destroy'])->name('alternatif.destroy')->middleware(IsOperator::class);
    Route::get('/kriteria', [KriteriaController::class, 'index']);
    Route::post('kriteria/store', [KriteriaController::class, 'store'])->name('kriteria.store')->middleware(IsOperator::class);
    Route::put('kriteria/update/{kriteria}', [KriteriaController::class, 'update'])->name('kriteria.update')->middleware(IsOperator::class);
    Route::delete('kriteria/delete/{id}', [KriteriaController::class, 'destroy'])->name('kriteria.destroy')->middleware(IsOperator::class);
    Route::get('/subkriteria', [SubKriteriaController::class, 'index']);
    Route::post('subkriteria/store', [SubKriteriaController::class, 'store'])->name('subkriteria.store')->middleware(IsOperator::class);
    Route::put('subkriteria/update/{subkriteria}', [SubKriteriaController::class, 'update'])->name('subkriteria.update')->middleware(IsOperator::class);
    Route::delete('subkriteria/delete/{id}', [SubKriteriaController::class, 'destroy'])->name('subkriteria.destroy')->middleware(IsOperator::class);
    Route::get('/penilaian', [NilaiController::class, 'index']);
    Route::get('/penilaian/add', [NilaiController::class, 'add'])->name('penilaian.add')->middleware(IsOperator::class);
    Route::post('penilaian/store', [NilaiController::class, 'store'])->name('penilaian.store')->middleware(IsOperator::class);
    Route::put('penilaian/update/{nilai}', [NilaiController::class, 'update'])->name('penilaian.update')->middleware(IsOperator::class);
    Route::delete('penilaian/delete/{id}', [NilaiController::class, 'destroy'])->name('penilaian.destroy')->middleware(IsOperator::class);
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/create', [ProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [ProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile/{id}/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/{id}', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class,'loginUser']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
