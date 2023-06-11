<?php

namespace App\Http\Controllers;

use App\Models\Belanja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TrxBelanjaSembakoImport;

class BelanjaController extends Controller
{
    public function index()
    {
        // FILTER BOX
        // get sembako data name and id
        $sembakos = DB::table('produks')
                    ->join('subkategoris', 'produks.id_subkategori', '=', 'subkategoris.id')
                    ->where('subkategoris.nama', 'sembako')
                    ->select('produks.id', 'produks.nama')
                    ->get();

        return view('pages.dt_sembako', [
            'sembakos' => $sembakos,
        ]);
    }

    public function manageData()
    {
        $sembakos = DB::table('belanjas')
                    ->join('produks', 'belanjas.id_produk', '=', 'produks.id')
                    ->join('subkategoris', 'produks.id_subkategori', '=', 'subkategoris.id')
                    ->where('subkategoris.nama', 'sembako')
                    ->select('belanjas.*', 'produks.nama', 'produks.satuan');
        
        return view('pages.dt_sembako_data', [
            'sembakos'=> $sembakos->paginate(30),
            'jmlTransaksi' => $sembakos->count(),
            'lastDataDate' => $sembakos->orderBy('tanggal', 'desc')->first()->tanggal ?? 'Belum ada data', // still bug in pagination
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
        $lastDate = DB::table('belanjas')
                    ->join('produks', 'belanjas.id_produk', '=', 'produks.id')
                    ->join('subkategoris', 'produks.id_subkategori', '=', 'subkategoris.id')
                    ->where('subkategoris.nama', 'sembako')
                    ->orderBy('tanggal', 'desc')
                    ->limit(1)
                    ->value('tanggal');
                    
        $justImported = DB::table('belanjas')
                    ->join('produks', 'belanjas.id_produk', '=', 'produks.id')
                    ->join('subkategoris', 'produks.id_subkategori', '=', 'subkategoris.id')
                    ->where('subkategoris.nama', '=', 'sembako')
                    ->where('belanjas.tanggal', '=', $lastDate)
                    ->select('belanjas.*', 'produks.nama', 'produks.satuan')
                    ->get();

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

    public function getData()
    {
        // // -- chart ringkasan
        $getDataRingkasan = DB::table('belanjas')
                    ->join('produks', 'belanjas.id_produk', '=', 'produks.id')
                    ->join('subkategoris', 'produks.id_subkategori', '=', 'subkategoris.id')
                    ->where('subkategoris.nama', 'sembako')
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
                    ->where('subkategoris.nama', 'sembako')
                    ->select(DB::raw('SUM(belanjas.jumlah) as tot_jumlah, produks.nama'))
                    ->groupBy('belanjas.id_produk')
                    ->orderBy('tot_jumlah', 'desc')
                    ->limit(5)
                    ->get();
        $dataRank = $getDataRank->mapWithKeys(function ($item, $key) {
            return [$item->nama => $item->tot_jumlah];
        });

        $data = [
            'totals' => $dataRingkasan,
            'tglAwalRingkasan' => $tglAwalRingkasan,
            'tglAkhirRingkasan' => $tglAkhirRingkasan,
            'ranks' => $dataRank,
        ];

        return response()->json($data);
    }

    public function getDataFilter(Request $request)
    {
        if(request('tgl-awal') != null) {
            $tglAwalFilter = request('tgl-awal');
        } else {
            $tglAwalFilter = DB::table('belanjas')
                    ->join('produks', 'belanjas.id_produk', '=', 'produks.id')
                    ->join('subkategoris', 'produks.id_subkategori', '=', 'subkategoris.id')
                    ->where('subkategoris.nama', 'sembako')
                    ->min('tanggal');
        }

        if(request('tgl-akhir') != null) {
            $tglAkhirFilter = request('tgl-akhir');
        } else {
            $tglAkhirFilter = DB::table('belanjas')
                    ->join('produks', 'belanjas.id_produk', '=', 'produks.id')
                    ->join('subkategoris', 'produks.id_subkategori', '=', 'subkategoris.id')
                    ->where('subkategoris.nama', 'sembako')
                    ->max('tanggal');
        }

        // data type
        if(request('tipe') != null) {
            $tipe = request('tipe');
        } else {
            $tipe = 'jumlah';
        }

        // product 1
        $idProductFilter = request('barang1');
        $getDataFiltered = DB::table('belanjas')->select($tipe, 'tanggal')
                        ->where('id_produk', $idProductFilter)
                        ->where('tanggal', '>=', $tglAwalFilter)
                        ->where('tanggal', '<=', $tglAkhirFilter)
                        ->orderBy('tanggal')
                        ->get();
        
        $dataFiltered = $getDataFiltered->mapWithKeys(function ($item, $key) {
            if(request('tipe') == 'harga_satuan')
                return [$item->tanggal => $item->harga_satuan];
            else if(request('tipe') == 'jumlah')
                return [$item->tanggal => $item->jumlah];
        });

        $productName = DB::table('produks')->where('id', $idProductFilter)->value('nama');

        // product 2
        $idProductFilter2 = request('barang2');
        $getDataFiltered2 = DB::table('belanjas')->select($tipe, 'tanggal')
                        ->where('id_produk', $idProductFilter2)
                        ->where('tanggal', '>=', $tglAwalFilter)
                        ->where('tanggal', '<=', $tglAkhirFilter)
                        ->orderBy('tanggal')
                        ->get();
        
        $dataFiltered2 = $getDataFiltered2->mapWithKeys(function ($item, $key) {
            if(request('tipe') == 'harga_satuan')
                return [$item->tanggal => $item->harga_satuan];
            else if(request('tipe') == 'jumlah')
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

    public function pdfSembako()
    {
        return view('export.dt_sembako_pdf');
    }
}
