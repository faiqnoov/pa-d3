<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index()
    {
        return view('pages.dm_produk', [
            'produks' => Produk::all(),
            'jmlProduk' => Produk::count()
        ]);
    }
}
