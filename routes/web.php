<?php

use App\Http\Controllers\BelanjaBahanController;
use App\Http\Controllers\BelanjaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
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

Route::get('/', [HomeController::class, 'index'])->middleware('auth');

Route::get('/upload', function () {
    return view('pages.upload');
});

Route::get('/produk', [ProdukController::class, 'index'])->middleware('auth');
Route::post('/produk/sembako', [ProdukController::class, 'importMstSembako']);
Route::post('/produk/bahan', [ProdukController::class, 'importMstBahan']);
Route::post('/produk/prdkantin', [ProdukController::class, 'importMstPrdKantin']);

Route::get('/kategori', [KategoriController::class, 'index']);
Route::get('/kategori/search', [KategoriController::class, 'search']);
Route::get('/kategori/load', [KategoriController::class, 'load']);

// -- belanja sembako --
Route::get('belanja/sembako', [BelanjaController::class, 'index'])->middleware('auth');
Route::get('belanja/sembako/data', [BelanjaController::class, 'manageData']);
Route::post('belanja/sembako/data', [BelanjaController::class, 'importBelanjaSembako']); 
Route::get('belanja/sembako/prev', [BelanjaController::class, 'previewImport']);
Route::get('belanja/sembako/{sembako}', [BelanjaController::class, 'previewImpEdit']);
Route::post('belanja/sembako/{sembako}', [BelanjaController::class, 'previewImpUpdate']);
Route::delete('belanja/sembako/{sembako}', [BelanjaController::class, 'previewImpDelete']);
Route::get('getdata/sembako', [BelanjaController::class, 'getData']);
Route::get('getdatafilter/sembako', [BelanjaController::class, 'getDataFilter']);
Route::get('pdf/sembako', [BelanjaController::class, 'pdfSembako']);

// -- belanja bahan --
Route::get('belanja/bahan', [BelanjaBahanController::class, 'index'])->middleware('auth');
Route::get('belanja/bahan/data', [BelanjaBahanController::class, 'manageData']);
Route::post('belanja/bahan/data', [BelanjaBahanController::class, 'importBelanjaBahan']); 
Route::get('belanja/bahan/prev', [BelanjaBahanController::class, 'previewImport']);
Route::get('belanja/bahan/{bahan}', [BelanjaBahanController::class, 'previewImpEdit']); 
Route::post('belanja/bahan/{bahan}', [BelanjaBahanController::class, 'previewImpUpdate']);
Route::delete('belanja/bahan/{bahan}', [BelanjaBahanController::class, 'previewImpDelete']);

// -- penjualan produk kantin --
Route::get('penjualan/kantin', [PenjualanController::class, 'index'])->middleware('auth');
Route::get('penjualan/kantin/data', [PenjualanController::class, 'manageData']);
Route::post('penjualan/kantin/data', [PenjualanController::class, 'importJualKantin']);
Route::get('penjualan/kantin/prev', [PenjualanController::class, 'previewImport']);
Route::get('penjualan/kantin/{prdkantin}', [PenjualanController::class, 'previewImpEdit']); 
Route::post('penjualan/kantin/{prdkantin}', [PenjualanController::class, 'previewImpUpdate']);
Route::delete('penjualan/kantin/{prdkantin}', [PenjualanController::class, 'previewImpDelete']);
Route::get('/kantin/getdata', [PenjualanController::class, 'getData']);
Route::get('/kantin/getdatafilter', [PenjualanController::class, 'getDataFilter']);
Route::get('/kantin/pdf', [PenjualanController::class, 'pdfKantin']);

Route::get('/petunjuk', function () {
    return view('others.petunjuk');
});

// -- auth -- 
Route::get('/user', [UserController::class, 'index'])->middleware('auth');
Route::get('/user/register', [RegisterController::class, 'index'])->middleware('auth');
Route::post('/user/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

