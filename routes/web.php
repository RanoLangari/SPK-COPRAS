<?php

use App\Http\Controllers\AlternatifController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\SubKriteriaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'home'])->middleware('auth');
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class,'loginUser']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/alternatif', [AlternatifController::class, 'index'] )->middleware('auth');
Route::post('alternatif/store', [AlternatifController::class, 'store'])->middleware('auth')->name('alternatif.store');
Route::put('alternatif/update/{alternatif}', [AlternatifController::class, 'update'])->middleware('auth')->name('alternatif.update');
Route::delete('alternatif/delete/{id}', [AlternatifController::class, 'destroy'])->middleware('auth')->name('alternatif.destroy');
Route::get('/kriteria', [KriteriaController::class, 'index'])->middleware('auth');
Route::post('kriteria/store', [KriteriaController::class, 'store'])->middleware('auth')->name('kriteria.store');
Route::put('kriteria/update/{kriteria}', [KriteriaController::class, 'update'])->middleware('auth')->name('kriteria.update');
Route::delete('kriteria/delete/{id}', [KriteriaController::class, 'destroy'])->middleware('auth')->name('kriteria.destroy');
Route::get('/subkriteria', [SubKriteriaController::class, 'index'])->middleware('auth');
Route::post('subkriteria/store', [SubKriteriaController::class, 'store'])->middleware('auth')->name('subkriteria.store');
Route::put('subkriteria/update/{subkriteria}', [SubKriteriaController::class, 'update'])->middleware('auth')->name('subkriteria.update');
Route::delete('subkriteria/delete/{id}', [SubKriteriaController::class, 'destroy'])->middleware('auth')->name('subkriteria.destroy');
Route::get('/penilaian', [NilaiController::class, 'index'])->middleware('auth');
route::get('/penilaian/add', [NilaiController::class, 'add'])->middleware('auth')->name('penilaian.add');
Route::post('penilaian/store', [NilaiController::class, 'store'])->middleware('auth')->name('penilaian.store');
Route::put('penilaian/update/{nilai}', [NilaiController::class, 'update'])->middleware('auth')->name('penilaian.update');
Route::delete('penilaian/delete/{id}', [NilaiController::class, 'destroy'])->middleware('auth')->name('penilaian.destroy');

