<?php

namespace App\Http\Controllers;

use App\Models\Subkategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function index()
    {
        return view('pages.dm_kategori', [
            // 'subkategoris' => Subkategori::all(),
            'jmlSubkategori' => Subkategori::count()
        ]);
    }
    
    public function load()
    {
        $categories = DB::table('subkategoris')
                ->join('kategoris', 'subkategoris.id_kategori', '=', 'kategoris.id')
                ->select('kategoris.nama as kategori', 'subkategoris.nama as subkategori')
                ->get();

        return response()->json($categories);
    }

    public function search(Request $request)
    {
        $filteredData = DB::table('subkategoris')
                ->join('kategoris', 'subkategoris.id_kategori', '=', 'kategoris.id')
                ->where('subkategoris.nama', 'like', '%' . $request->keyword . '%')
                ->orWhere('kategoris.nama', 'like', '%' . $request->keyword . '%')
                ->select('kategoris.nama as kategori', 'subkategoris.nama as subkategori')
                ->get();

        return response()->json($filteredData);
    }
}
