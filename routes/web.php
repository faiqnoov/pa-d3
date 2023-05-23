<?php

use App\Http\Controllers\BelanjaBahanController;
use App\Http\Controllers\BelanjaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
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

Route::get('/', [HomeController::class, 'index']);

Route::get('/upload', function () {
    return view('pages.upload');
});

Route::get('/produk', [ProdukController::class, 'index']);
Route::post('/produk/sembako', [ProdukController::class, 'importMstSembako']);
Route::post('/produk/bahan', [ProdukController::class, 'importMstBahan']);
Route::post('/produk/prdkantin', [ProdukController::class, 'importMstPrdKantin']);

Route::get('/kategori', [KategoriController::class, 'index']);

Route::get('belanja/sembako', [BelanjaController::class, 'index']);
Route::get('belanja/sembako/data', [BelanjaController::class, 'manageData']);
Route::post('belanja/sembako/data', [BelanjaController::class, 'importBelanjaSembako']); 
Route::get('belanja/sembako/prev', [BelanjaController::class, 'previewImport']);
Route::get('belanja/sembako/{sembako}', [BelanjaController::class, 'previewImpEdit']); 
Route::post('belanja/sembako/{sembako}', [BelanjaController::class, 'previewImpUpdate']);
Route::delete('belanja/sembako/{sembako}', [BelanjaController::class, 'previewImpDelete']);

Route::get('belanja/bahan', [BelanjaBahanController::class, 'index']);
Route::get('belanja/bahan/data', [BelanjaBahanController::class, 'manageData']);
Route::post('belanja/bahan/data', [BelanjaBahanController::class, 'importBelanjaBahan']); 
Route::get('belanja/bahan/prev', [BelanjaBahanController::class, 'previewImport']);
Route::get('belanja/bahan/{bahan}', [BelanjaBahanController::class, 'previewImpEdit']); 
Route::post('belanja/bahan/{bahan}', [BelanjaBahanController::class, 'previewImpUpdate']);
Route::delete('belanja/bahan/{bahan}', [BelanjaBahanController::class, 'previewImpDelete']);

Route::get('penjualan/kantin', [PenjualanController::class, 'index']);
Route::get('penjualan/kantin/data', [PenjualanController::class, 'manageData']);
Route::post('penjualan/kantin/data', [PenjualanController::class, 'importJualKantin']);
Route::get('penjualan/kantin/prev', [PenjualanController::class, 'previewImport']);
Route::get('penjualan/kantin/{prdkantin}', [PenjualanController::class, 'previewImpEdit']); 
Route::post('penjualan/kantin/{prdkantin}', [PenjualanController::class, 'previewImpUpdate']);
Route::delete('penjualan/kantin/{prdkantin}', [PenjualanController::class, 'previewImpDelete']);

