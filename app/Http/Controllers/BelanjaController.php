<?php

namespace App\Http\Controllers;

use App\Imports\TrxBelanjaSembakoImport;
use App\Models\Belanja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BelanjaController extends Controller
{
    public function index()
    {
        // // -- chart ringkasan
        $getDataRingkasan = DB::table('belanjas')->select(DB::raw('SUM(harga_satuan*jumlah) AS total_belanja, tanggal'))
                    ->groupBy('tanggal')
                    ->orderBy('tanggal')
                    // ->limit(6)
                    ->get();

        $dataRingkasan = $getDataRingkasan->mapWithKeys(function ($item, $key) {
            return [$item->tanggal => $item->total_belanja];
        });

        // -- chart ranking
        // akumulasi semua data
        // tapi satuannya beda2 cuyy
        $getDataRank = DB::table('belanjas')
                    ->join('produks', 'belanjas.id_produk', '=', 'produks.id')
                    ->select(DB::raw('SUM(belanjas.jumlah) as tot_jumlah, produks.nama'))
                    ->groupBy('belanjas.id_produk')
                    ->orderBy('tot_jumlah', 'desc')
                    ->limit(5)
                    ->get();

        $dataRank = $getDataRank->mapWithKeys(function ($item, $key) {
            return [$item->nama => $item->tot_jumlah];
        });
        // dd($dataRank);

        // -- chart filter
        $idProductFilter = 649;
        $getDataFiltered = DB::table('belanjas')->select(DB::raw('jumlah, tanggal'))
                        ->where('id_produk', $idProductFilter)
                        ->orderBy('tanggal')
                        ->get();
        
        $dataFiltered = $getDataFiltered->mapWithKeys(function ($item, $key) {
            return [$item->tanggal => $item->jumlah];
        });

        $productName = DB::table('produks')->where('id', $idProductFilter)->value('nama');
        
        $idProductFilter2 = 651;
        $getDataFiltered2 = DB::table('belanjas')->select(DB::raw('jumlah, tanggal'))
                        ->where('id_produk', $idProductFilter2)
                        ->orderBy('tanggal')
                        ->get();
        
        $dataFiltered2 = $getDataFiltered2->mapWithKeys(function ($item, $key) {
            return [$item->tanggal => $item->jumlah];
        });

        $productName2 = DB::table('produks')->where('id', $idProductFilter2)->value('nama');


        return view('pages.dt_sembako', [
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

        return redirect('/belanja/sembako/prev');
    }

    public function previewImport()
    {
        $lastDate = DB::table('belanjas')->orderBy('tanggal', 'desc')->limit(1)->value('tanggal');
        $justImported = Belanja::where('tanggal', $lastDate)->get();

        return view('pages.dt_sembako_data_prev', [
            'datas' => $justImported,
            'jmlData' => $justImported->count(),
            'tglData' => $justImported->last()->tanggal,
        ]);
    }

    public function previewImpEdit($id)
    // public function previewImpEdit(Belanja $belanja)
    {
        return view('pages.dt_sembako_data_prev_e', [
            'belanja' => Belanja::find($id),
            // 'belanja' => $belanja,
        ]);
    }

    public function previewImpUpdate(Request $request, $id)
    {
        $validatedData = $request->validate([
            // 'nama' => 'required|max:255',
            'jumlah' => 'required',
            'harga_satuan' => 'required',
        ]);

        Belanja::where('id', $id)->update($validatedData);

        return redirect('/belanja/sembako/prev')->with('success', 'Data berhasil diubah!');
    }

    public function previewImpDelete($id)
    {
        Belanja::destroy($id);

        return redirect('/belanja/sembako/prev')->with('success', 'Data berhasil dihapus!');
    }
}
