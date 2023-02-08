<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('pages.home');
});

Route::get('/upload', function () {
    return view('pages.upload');
});

Route::get('/produk', function () {
    return view('pages.dm_produk');
});

Route::get('/kategori', function () {
    return view('pages.dm_kategori');
});

Route::get('/sembako', function () {
    return view('pages.dt_sembako');
});

Route::get('/sembako/data', function () {
    return view('pages.dt_sembako_data');
});

Route::get('/sembako/data/preview', function () {
    return view('pages.dt_sembako_data_prev');
});
