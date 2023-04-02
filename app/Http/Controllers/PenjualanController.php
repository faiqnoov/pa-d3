<?php

namespace App\Http\Controllers;

use App\Imports\TrxJualKantinImport;
use App\Models\Penjualan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PenjualanController extends Controller
{
    public function index()
    {
        // $cireng = Penjualan::all();
        // $cireng = DB::table('Penjualans')->get();
        // $cireng = ['2023-11-30' => 123000000, '2023-12-31' => 99000];

        // -- chart ringkasan
        $getDataRingkasan = DB::table('penjualans')->select(DB::raw('SUM(penjualan_kotor) as total_penjualan, tanggal'))
                    ->groupBy('tanggal')
                    ->orderBy('tanggal')
                    ->limit(6)
                    ->get();

        $dataRingkasan = $getDataRingkasan->mapWithKeys(function ($item, $key) {
            return [$item->tanggal => $item->total_penjualan];
        });

        // -- chart ranking
        // pake join buat ambil nama produk(?)
        $getDataRank = DB::table('penjualans')->select(DB::raw('id_produk, jumlah'))
                    ->orderBy('jumlah', 'desc')
                    ->limit(5)
                    ->get();

        $dataRank = $getDataRank->mapWithKeys(function ($item, $key) {
            return [$item->id_produk => $item->jumlah];
        });

        // -- chart filter
        $idProdukFilter = 90;
        $getDataFiltered = DB::table('penjualans')->select(DB::raw('jumlah, tanggal'))
                        ->where('id_produk', $idProdukFilter)
                        ->get();
        
        $dataFiltered = $getDataFiltered->mapWithKeys(function ($item, $key) {
            return [$item->tanggal => $item->jumlah];
        });

        // dd($dataFiltered);

        return view('pages.dt_prdkantin', [
            'totals' => $dataRingkasan,
            'ranks' => $dataRank,
            'trens' => $dataFiltered,
            // 'barangTrens' => DB::table('produks')->where('id', $idProdukFilter)->get(),
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
