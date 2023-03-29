<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Subkategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        return view('pages.dm_kategori', [
            'subkategoris' => Subkategori::all(),
            'jmlSubkategori' => Subkategori::count()
        ]);
    }
}
