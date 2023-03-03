<?php

namespace App\Http\Controllers;

use App\Imports\TrxJualKantinImport;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PenjualanController extends Controller
{
    public function index()
    {
        return view('pages.dt_prdkantin', [
            'penjualans' => Penjualan::paginate(30)
        ]);
    }

    public function manageData()
    {
        return view('pages.dt_prdkantin_data', [
            'penjualans' => Penjualan::paginate(30),
            'jmlTransaksi' => Penjualan::count()
        ]);
    }

    public function importJualKantin(Request $request)
    {
        $file = $request->file('penjualanKantin');

        // get trx date form file name
        $filename = $file->getClientOriginalName();
        $explodedFileName = explode(' ', $filename);
        $rawDate = $explodedFileName[4];
        $date = ltrim($rawDate, '00_00_00sampai');
        
        Excel::import(new TrxJualKantinImport($date), $file);

        return redirect('/penjualan/kantin/data')->with('success', 'All good!');
    }
}
