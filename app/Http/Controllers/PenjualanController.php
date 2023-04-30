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
        // yg diambil hanya data pertama dari tiap penjualan produk
        $getDataRank = DB::table('penjualans')
                    ->join('produks', 'penjualans.id_produk', '=', 'produks.id')
                    ->select('penjualans.jumlah', 'produks.nama')
                    ->orderBy('jumlah', 'desc')
                    ->limit(5)
                    ->get();

        $dataRank = $getDataRank->mapWithKeys(function ($item, $key) {
            return [$item->nama => $item->jumlah];
        });
        // dd($dataRank);  

        // -- chart filter
        $idProductFilter = 22;
        $getDataFiltered = DB::table('penjualans')->select(DB::raw('jumlah, tanggal'))
                        ->where('id_produk', $idProductFilter)
                        ->orderBy('tanggal')
                        ->get();
        
        $dataFiltered = $getDataFiltered->mapWithKeys(function ($item, $key) {
            return [$item->tanggal => $item->jumlah];
        });

        $productName = DB::table('produks')->where('id', $idProductFilter)->value('nama');
        
        $idProductFilter2 = 102;
        $getDataFiltered2 = DB::table('penjualans')->select(DB::raw('jumlah, tanggal'))
                        ->where('id_produk', $idProductFilter2)
                        ->orderBy('tanggal')
                        ->get();
        
        $dataFiltered2 = $getDataFiltered2->mapWithKeys(function ($item, $key) {
            return [$item->tanggal => $item->jumlah];
        });

        $productName2 = DB::table('produks')->where('id', $idProductFilter2)->value('nama');

        // dd($dataFiltered2);

        return view('pages.dt_prdkantin', [
            'totals' => $dataRingkasan,
            'ranks' => $dataRank,
            'trends' => $dataFiltered,
            'trends2' => $dataFiltered2,
            'barangTrend' => $productName,
            'barangTrend2' => $productName2,
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

        return redirect('/penjualan/kantin/prev');
    }

    public function previewImport(){
        $lastDate = DB::table('penjualans')->orderBy('tanggal', 'desc')->limit(1)->value('tanggal');
        $justImported = Penjualan::where('tanggal', $lastDate)->get();

        return view('pages.dt_prdkantin_data_prev', [
            'datas' => $justImported,
            'jmlData' => $justImported->count(),
            'tglData' => $justImported->last()->tanggal,
        ]);
    }

    public function previewImpEdit($id)
    {
        return view('pages.dt_prdkantin_data_prev_e', [
            'data' => Penjualan::find($id),
        ]);
    }

    public function previewImpUpdate(Request $request, $id)
    {
        $validatedData = $request->validate([
            'jumlah' => 'required',
            'penjualan_kotor' => 'required',
        ]);

        Penjualan::where('id', $id)->update($validatedData);

        return redirect('/penjualan/kantin/prev')->with('success', 'Data berhasil diubah!');
    }

    public function previewImpDelete($id)
    {
        Penjualan::destroy($id);

        return redirect('/penjualan/kantin/prev')->with('success', 'Data berhasil dihapus!');
    }
}
