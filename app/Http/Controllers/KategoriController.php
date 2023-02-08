<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        return view('pages.dm_kategori', [
            'kategoris' => Kategori::all(),
            'jmlKategori' => Kategori::count()
        ]);
    }
}
