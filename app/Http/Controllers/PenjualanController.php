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
        // FILTER BOX
        // get produk kantin data and id
        $produkKantin = DB::table('produks')
                    ->join('subkategoris', 'produks.id_subkategori', '=', 'subkategoris.id')
                    ->where('subkategoris.nama', '!=', 'sembako')
                    ->where('subkategoris.nama', '!=', 'bahan masakan')
                    ->select('produks.id', 'produks.nama')
                    ->get();

        return view('pages.dt_prdkantin', [
            'produks' => $produkKantin,
        ]);
    }

    public function getData()
    {
        // -- chart ringkasan
        $getDataRingkasan = DB::table('penjualans')->select(DB::raw('SUM(penjualan_kotor) as total_penjualan, tanggal'))
                    ->groupBy('tanggal')
                    ->orderBy('tanggal')
                    ->limit(6)
                    ->get();

        $dataRingkasan = $getDataRingkasan->mapWithKeys(function ($item, $key) {
            return [$item->tanggal => $item->total_penjualan];
        });

        $tglAwalRingkasan = DB::table('penjualans')->min('tanggal');
        $tglAkhirRingkasan = DB::table('penjualans')->max('tanggal');

        // -- chart ranking
        // berdasarkan data terakhir
        $getDataRank = DB::table('penjualans')
                    ->join('produks', 'penjualans.id_produk', '=', 'produks.id')
                    ->where('penjualans.tanggal', '=', $tglAkhirRingkasan)
                    ->select('penjualans.jumlah', 'produks.nama')
                    ->orderBy('jumlah', 'desc')
                    ->limit(5)
                    ->get();

        $dataRank = $getDataRank->mapWithKeys(function ($item, $key) {
            return [$item->nama => $item->jumlah];
        });

        $data = [
            'totals' => $dataRingkasan,
            'tglAwalRingkasan' => $tglAwalRingkasan,
            'tglAkhirRingkasan' => $tglAkhirRingkasan,
            'ranks' => $dataRank,
        ];

        return response()->json($data);
    }

    public function getDataFilter()
    {
        // -- chart filter
        if(request('tgl-awal') != null) {
            $tglAwalFilter = request('tgl-awal');
        } else {
            $tglAwalFilter = DB::table('penjualans')->min('tanggal');
        }

        if(request('tgl-akhir') != null) {
            $tglAkhirFilter = request('tgl-akhir');
        } else {
            $tglAkhirFilter = DB::table('penjualans')->max('tanggal');
        }

        $idProductFilter = request('barang1');
        $getDataFiltered = DB::table('penjualans')->select(DB::raw('jumlah, tanggal'))
                        ->where('id_produk', $idProductFilter)
                        ->where('tanggal', '>=', $tglAwalFilter)
                        ->where('tanggal', '<=', $tglAkhirFilter)
                        ->orderBy('tanggal')
                        ->get();
        
        $dataFiltered = $getDataFiltered->mapWithKeys(function ($item, $key) {
            return [$item->tanggal => $item->jumlah];
        });

        $productName = DB::table('produks')->where('id', $idProductFilter)->value('nama');
        
        $idProductFilter2 = request('barang2');
        $getDataFiltered2 = DB::table('penjualans')->select(DB::raw('jumlah, tanggal'))
                        ->where('id_produk', $idProductFilter2)
                        ->where('tanggal', '>=', $tglAwalFilter)
                        ->where('tanggal', '<=', $tglAkhirFilter)
                        ->orderBy('tanggal')
                        ->get();
        
        $dataFiltered2 = $getDataFiltered2->mapWithKeys(function ($item, $key) {
            return [$item->tanggal => $item->jumlah];
        });

        $productName2 = DB::table('produks')->where('id', $idProductFilter2)->value('nama');

        $data = [
            'trends' => $dataFiltered,
            'trends2' => $dataFiltered2,
            'barangTrend' => $productName,
            'barangTrend2' => $productName2,
            'tglAwalFilter' => $tglAwalFilter,
            'tglAkhirFilter' => $tglAkhirFilter,
        ];

        return response()->json($data);
    }

    public function pdfKantin()
    {
        return view('export.dt_prdkantin_pdf');
    }

    public function manageData()
    {
        return view('pages.dt_prdkantin_data', [
            'penjualans' => Penjualan::paginate(30),
            'jmlTransaksi' => Penjualan::count(),
            'lastDataDate' => Penjualan::orderBy('tanggal', 'desc')->limit(1)->value('tanggal'),
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
