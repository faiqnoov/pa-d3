<?php

namespace App\Http\Controllers;

use App\Imports\TrxBelanjaSembakoImport;
use App\Models\Belanja;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BelanjaController extends Controller
{
    public function index()
    {
        return view('pages.dt_sembako');
    }

    public function manageData()
    {
        return view('pages.dt_sembako_data', [
            'sembakos'=> Belanja::with('produk')->paginate(10),
            'jmlTransaksi' => Belanja::count(),
        ]);
    }

    public function importBelanjaSembako(Request $request)
    {
        $request->validate([
            'belanjaSembako' => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('belanjaSembako');

        // get trx date form file name
        $filename = $file->getClientOriginalName();
        $explodedFileName = explode(' ', $filename);
        $rawDate = $explodedFileName[3];
        $date = rtrim($rawDate, '.xlsx');

        Excel::import(new TrxBelanjaSembakoImport($date), $file);

        return redirect('/belanja/sembako/data')->with('success', 'Data berhasil diimport');
    }
}
