<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('login', function () {
    $data = array();
    $data['title'] = "Login";
    return view('auth/login', $data);
})->name('login');
Route::post('actionlogin', [App\Http\Controllers\LoginController::class, 'actionlogin'])->name('actionlogin');
Route::get('actionlogout', [App\Http\Controllers\LoginController::class, 'actionlogout'])->name('actionlogout');

/**
 * route resource siswa
 */
Route::get('home', function () {
    $data = array();
    $data['title'] = "home";
    return view('pages/home', $data);
})->name('home');
Route::get('/filter-data', [App\Http\Controllers\BukuController::class, 'filterData'])->name('filterData');
Route::get('/alldata', [App\Http\Controllers\BukuController::class, 'alldata'])->name('alldata');
Route::resource('/buku', App\Http\Controllers\BukuController::class)->middleware('auth');
Route::resource('/kategori', App\Http\Controllers\KategoriBukuController::class)->middleware('auth');
Route::get('/carikategori', [App\Http\Controllers\KategoriBukuController::class, 'carikategori'])->middleware('auth');