<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
use App\Imports\MstBahanImport;
use App\Imports\MstSembakoImport;
use App\Imports\MstPrdKantinImport;
use Maatwebsite\Excel\Facades\Excel;

class ProdukController extends Controller
{
    public function index()
    {
        return view('pages.dm_produk', [
            'produks' => Produk::paginate(20),
            'jmlProduk' => Produk::count()
        ]);
    }

    public function importMstSembako(Request $request) 
    {
        $file = $request->file('file');

        Excel::import(new MstSembakoImport, $file);
        
        return redirect('/produk')->with('success', 'Data produk (Sembako) berhasil diperbarui!');
    }

    public function importMstBahan(Request $request) 
    {
        $file = $request->file('bahan_masak');

        Excel::import(new MstBahanImport, $file);
        
        return redirect('/produk')->with('success', 'Data produk (Bahan Masakan) berhasil diperbarui!');
    }

    public function importMstPrdKantin(Request $request) 
    {
        $file = $request->file('prd_kantin');

        Excel::import(new MstPrdKantinImport, $file);
        
        return redirect('/produk')->with('success', 'Data produk (Produk Kantin) berhasil diperbarui!');
    }
}
