<?php

namespace App\Http\Controllers;

use App\Models\Belanja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TrxBelanjaBahanImport;

class BelanjaBahanController extends Controller
{
    public function index()
    {
        // -- chart ringkasan
        $getDataRingkasan = DB::table('belanjas')
                    ->join('produks', 'belanjas.id_produk', '=', 'produks.id')
                    ->join('subkategoris', 'produks.id_subkategori', '=', 'subkategoris.id')
                    ->where('subkategoris.nama', 'bahan masakan')
                    ->select(DB::raw('SUM(belanjas.harga_satuan * belanjas.jumlah) AS total_belanja, belanjas.tanggal'))
                    ->groupBy('tanggal')
                    ->orderBy('tanggal')
                    // ->limit(6)
                    ->get();

        $dataRingkasan = $getDataRingkasan->mapWithKeys(function ($item, $key) {
            return [$item->tanggal => $item->total_belanja];
        });

        $tglAwalRingkasan = DB::table('belanjas')->min('tanggal');
        $tglAkhirRingkasan = DB::table('belanjas')->max('tanggal');

        // -- chart ranking
        // akumulasi semua data
        // tapi satuannya beda2 cuyy
        $getDataRank = DB::table('belanjas')
                    ->join('produks', 'belanjas.id_produk', '=', 'produks.id')
                    ->join('subkategoris', 'produks.id_subkategori', '=', 'subkategoris.id')
                    ->where('subkategoris.nama', 'bahan masakan')
                    ->select(DB::raw('SUM(belanjas.jumlah) as tot_jumlah, produks.nama'))
                    ->groupBy('belanjas.id_produk')
                    ->orderBy('tot_jumlah', 'desc')
                    ->limit(5)
                    ->get();
        $dataRank = $getDataRank->mapWithKeys(function ($item, $key) {
            return [$item->nama => $item->tot_jumlah];
        });

        // -- chart filter

        if(request('tgl-awal') != null) {
            $tglAwalFilter = request('tgl-awal');
        } else {
            $tglAwalFilter = DB::table('belanjas')
                    ->join('produks', 'belanjas.id_produk', '=', 'produks.id')
                    ->join('subkategoris', 'produks.id_subkategori', '=', 'subkategoris.id')
                    ->where('subkategoris.nama', 'bahan masakan')
                    ->min('tanggal');
        }

        if(request('tgl-akhir') != null) {
            $tglAkhirFilter = request('tgl-akhir');
        } else {
            $tglAkhirFilter = DB::table('belanjas')
                    ->join('produks', 'belanjas.id_produk', '=', 'produks.id')
                    ->join('subkategoris', 'produks.id_subkategori', '=', 'subkategoris.id')
                    ->where('subkategoris.nama', 'bahan masakan')
                    ->max('tanggal');
        }

        // product 1
        $idProductFilter = request('barang1');
        $getDataFiltered = DB::table('belanjas')->select(DB::raw('jumlah, tanggal'))
                        ->where('id_produk', $idProductFilter)
                        ->where('tanggal', '>=', $tglAwalFilter)
                        ->where('tanggal', '<=', $tglAkhirFilter)
                        ->orderBy('tanggal')
                        ->get();
        
        $dataFiltered = $getDataFiltered->mapWithKeys(function ($item, $key) {
            return [$item->tanggal => $item->jumlah];
        });

        $productName = DB::table('produks')->where('id', $idProductFilter)->value('nama');

        // product 2
        $idProductFilter2 = request('barang2');
        $getDataFiltered2 = DB::table('belanjas')->select(DB::raw('jumlah, tanggal'))
                        ->where('id_produk', $idProductFilter2)
                        ->where('tanggal', '>=', $tglAwalFilter)
                        ->where('tanggal', '<=', $tglAkhirFilter)
                        ->orderBy('tanggal')
                        ->get();
        
        $dataFiltered2 = $getDataFiltered2->mapWithKeys(function ($item, $key) {
            return [$item->tanggal => $item->jumlah];
        });

        $productName2 = DB::table('produks')->where('id', $idProductFilter2)->value('nama');

        // FILTER BOX
        // get bahan data name and id
        $bahans = DB::table('produks')
                    ->join('subkategoris', 'produks.id_subkategori', '=', 'subkategoris.id')
                    ->where('subkategoris.nama', 'bahan masakan')
                    ->select('produks.id', 'produks.nama')
                    ->get();

        return view('pages.dt_bahan', [
            'totals' => $dataRingkasan,
            'tglAwalRingkasan' => $tglAwalRingkasan,
            'tglAkhirRingkasan' => $tglAkhirRingkasan,
            'ranks' => $dataRank,
            'trends' => $dataFiltered,
            'trends2' => $dataFiltered2,
            'barangTrend' => $productName,
            'barangTrend2' => $productName2,

            'bahans' => $bahans,
            'tglAwalFilter' => $tglAwalFilter,
            'tglAkhirFilter' => $tglAkhirFilter,
        ]);
    }

    public function manageData()
    {
        $bahans = DB::table('belanjas')
                ->join('produks', 'belanjas.id_produk', '=', 'produks.id')
                ->join('subkategoris', 'produks.id_subkategori', '=', 'subkategoris.id')
                ->where('subkategoris.nama', '=', 'bahan masakan')
                ->select('belanjas.*', 'produks.nama', 'produks.satuan')
                ->paginate(10);

        return view('pages.dt_bahan_data', [
            'bahans'=> $bahans,
            'jmlTransaksi' => $bahans->total(),
        ]);
    }

    public function importBelanjaBahan(Request $request)
    {
        $request->validate([
            'belanjaBahan' => 'required|mimes:xls,xlsx',
        ]);

        $file = $request->file('belanjaBahan');
        
        // get trx date form file name
        $filename = $file->getClientOriginalName();
        $explodedFileName = explode(' ', $filename);
        $rawDate = $explodedFileName[3];
        $date = rtrim($rawDate, '.xlsx');

        Excel::import(new TrxBelanjaBahanImport($date), $file);

        return redirect('/belanja/bahan/prev');
    }

    public function previewImport()
    {
        $lastDate = DB::table('belanjas')
                    ->join('produks', 'belanjas.id_produk', '=', 'produks.id')
                    ->join('subkategoris', 'produks.id_subkategori', '=', 'subkategoris.id')
                    ->where('subkategoris.nama', 'bahan masakan')
                    ->orderBy('tanggal', 'desc')
                    ->limit(1)
                    ->value('tanggal');
                    
        $justImported = DB::table('belanjas')
                    ->join('produks', 'belanjas.id_produk', '=', 'produks.id')
                    ->join('subkategoris', 'produks.id_subkategori', '=', 'subkategoris.id')
                    ->where('subkategoris.nama', '=', 'bahan masakan')
                    ->where('belanjas.tanggal', '=', $lastDate)
                    ->select('belanjas.*', 'produks.nama', 'produks.satuan')
                    ->get();

        return view('pages.dt_bahan_data_prev', [
            'datas' => $justImported,
            'jmlData' => $justImported->count(),
            'tglData' => $justImported->last()->tanggal,
        ]);
    }

    public function previewImpEdit($id)
    {
        return view('pages.dt_bahan_data_prev_e', [
            'belanja' => Belanja::find($id),
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

        return redirect('/belanja/bahan/prev')->with('success', 'Data berhasil diubah!');
    }

    public function previewImpDelete($id)
    {
        Belanja::destroy($id);

        return redirect('/belanja/bahan/prev')->with('success', 'Data berhasil dihapus!');
    }
}