<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // -- insight
        // nominal penjualan kantin
        $nominalPenjualan = DB::table('penjualans')->select(DB::raw('SUM(penjualan_kotor) as total_penjualan, tanggal'))
                    // ->whereMonth('tanggal', date('01'))
                    // ->whereYear('tanggal', date('2023'))
                    ->groupBy('tanggal')
                    ->orderBy('tanggal', 'desc')
                    ->limit(2)
                    ->get();

        if(count($nominalPenjualan) > 1) {
            $penjualanBulanIni = $nominalPenjualan[0]->total_penjualan;
            $penjualanBulanLalu = $nominalPenjualan[1]->total_penjualan;
        } elseif(count($nominalPenjualan) == 1) {
            $penjualanBulanIni = $nominalPenjualan[0]->total_penjualan;
            $penjualanBulanLalu = 0;
        } else {
            $penjualanBulanIni = 0;
            $penjualanBulanLalu = 0;
        }

        $selisihPenjualan = $penjualanBulanIni - $penjualanBulanLalu;
        if($penjualanBulanLalu == 0) {
            $persentasePenjualan = 100;
        } else {
            $persentasePenjualan = round(($selisihPenjualan / $penjualanBulanLalu) * 100);
        }

        // nominal belanja sembako
        $nominalBelanjaSembako = DB::table('belanjas')
                    ->join('produks', 'belanjas.id_produk', '=', 'produks.id')
                    ->join('subkategoris', 'produks.id_subkategori', '=', 'subkategoris.id')
                    ->where('subkategoris.nama', 'sembako')
                    ->select(DB::raw('SUM(harga_satuan*jumlah) AS total_belanja, tanggal'))
                    // ->whereMonth('tanggal', date('01'))
                    // ->whereYear('tanggal', date('2023'))
                    ->groupBy('tanggal')
                    ->orderBy('tanggal', 'desc')
                    ->limit(2)
                    ->get();

        if(count($nominalBelanjaSembako) > 1) {
            $belanjaSembakoBulanIni = $nominalBelanjaSembako[0]->total_belanja;
            $belanjaSembakoBulanLalu = $nominalBelanjaSembako[1]->total_belanja;
        } elseif(count($nominalBelanjaSembako) == 1) {
            $belanjaSembakoBulanIni = $nominalBelanjaSembako[0]->total_belanja;
            $belanjaSembakoBulanLalu = 0;
        } else {
            $belanjaSembakoBulanIni = 0;
            $belanjaSembakoBulanLalu = 0;
        }

        $selisihBelanjaSembako = $belanjaSembakoBulanIni - $belanjaSembakoBulanLalu;
        if($belanjaSembakoBulanLalu == 0) {
            $persentaseBelanjaSembako = 100;
        } else {
            $persentaseBelanjaSembako = round(($selisihBelanjaSembako / $belanjaSembakoBulanLalu) * 100);
        }

        // nominal belanja bahan masakan
        $nominalBelanjaBahan = DB::table('belanjas')
                    ->join('produks', 'belanjas.id_produk', '=', 'produks.id')
                    ->join('subkategoris', 'produks.id_subkategori', '=', 'subkategoris.id')
                    ->where('subkategoris.nama', 'bahan masakan')
                    ->select(DB::raw('SUM(harga_satuan*jumlah) AS total_belanja, tanggal'))
                    ->groupBy('tanggal')
                    ->orderBy('tanggal', 'desc')
                    ->limit(2)
                    ->get();

        if(count($nominalBelanjaBahan) > 1) {
            $belanjaBahanBulanIni = $nominalBelanjaBahan[0]->total_belanja;
            $belanjaBahanBulanLalu = $nominalBelanjaBahan[1]->total_belanja;
        } elseif(count($nominalBelanjaBahan) == 1) {
            $belanjaBahanBulanIni = $nominalBelanjaBahan[0]->total_belanja;
            $belanjaBahanBulanLalu = 0;
        } else {
            $belanjaBahanBulanIni = 0;
            $belanjaBahanBulanLalu = 0;
        }

        $selisihBelanjaBahan = $belanjaBahanBulanIni - $belanjaBahanBulanLalu;
        if($belanjaBahanBulanLalu == 0) {
            $persentaseBelanjaBahan = 100;
        } else {
            $persentaseBelanjaBahan = round(($selisihBelanjaBahan / $belanjaBahanBulanLalu) * 100);
        }

        // ga akurat, karena satuan beda2
        $sembakoTerbanyak = DB::table('belanjas')
                    ->join('produks', 'belanjas.id_produk', '=', 'produks.id')
                    ->join('subkategoris', 'produks.id_subkategori', '=', 'subkategoris.id')
                    ->where('subkategoris.nama', 'sembako')
                    ->select(DB::raw('belanjas.tanggal, belanjas.jumlah, produks.nama'))
                    ->groupBy('belanjas.id_produk', 'belanjas.tanggal')
                    ->orderBy('jumlah', 'desc')
                    ->limit(1)
                    ->get();
        
        // ga akurat, karena satuan beda2
        $bahanTerbanyak = DB::table('belanjas')
                    ->join('produks', 'belanjas.id_produk', '=', 'produks.id')
                    ->select(DB::raw('belanjas.tanggal, belanjas.jumlah, produks.nama'))
                    ->join('subkategoris', 'produks.id_subkategori', '=', 'subkategoris.id')
                    ->where('subkategoris.nama', 'bahan masakan')
                    ->groupBy('belanjas.id_produk', 'belanjas.tanggal')
                    ->orderBy('jumlah', 'desc')
                    ->limit(1)
                    ->get();
        
        $produkKantinTerbanyak = DB::table('penjualans')
                    ->join('produks', 'penjualans.id_produk', '=', 'produks.id')
                    ->select(DB::raw('penjualans.tanggal, penjualans.jumlah, produks.nama'))
                    ->groupBy('penjualans.id_produk', 'penjualans.tanggal')
                    ->orderBy('jumlah', 'desc')
                    ->limit(1)
                    ->get();

        // -- chart penjualan kantin
        $getDataKantin = DB::table('penjualans')->select(DB::raw('SUM(penjualan_kotor) as total_penjualan, tanggal'))
                    ->groupBy('tanggal')
                    ->orderBy('tanggal')
                    ->limit(6)
                    ->get();

        $dataKantin = $getDataKantin->mapWithKeys(function ($item, $key) {
            return [$item->tanggal => $item->total_penjualan];
        });

        // -- chart belanja sembako
        $getDataSembako = DB::table('belanjas')
                    ->join('produks', 'belanjas.id_produk', '=', 'produks.id')
                    ->join('subkategoris', 'produks.id_subkategori', '=', 'subkategoris.id')
                    ->where('subkategoris.nama', 'sembako')
                    ->select(DB::raw('SUM(belanjas.harga_satuan * belanjas.jumlah) AS total_belanja, belanjas.tanggal'))
                    ->groupBy('tanggal')
                    ->orderBy('tanggal')
                    ->limit(6)
                    ->get();

        $dataSembako = $getDataSembako->mapWithKeys(function ($item, $key) {
            return [$item->tanggal => $item->total_belanja];
        });

        // -- chart belanja bahan masakan
        $getDataBahan = DB::table('belanjas')
                    ->join('produks', 'belanjas.id_produk', '=', 'produks.id')
                    ->join('subkategoris', 'produks.id_subkategori', '=', 'subkategoris.id')
                    ->where('subkategoris.nama', 'bahan masakan')
                    ->select(DB::raw('SUM(belanjas.harga_satuan * belanjas.jumlah) AS total_belanja, belanjas.tanggal'))
                    ->groupBy('tanggal')
                    ->orderBy('tanggal')
                    ->limit(6)
                    ->get();

        $dataBahan = $getDataBahan->mapWithKeys(function ($item, $key) {
            return [$item->tanggal => $item->total_belanja];
        });

        return view('pages.home', [
            'penjualanBulanIni' => $penjualanBulanIni,
            'persentasePenjualan' => $persentasePenjualan,
            'belanjaSembakoBulanIni' => $belanjaSembakoBulanIni,
            'persentaseBelanjaSembako' => $persentaseBelanjaSembako,
            'belanjaBahanBulanIni' => $belanjaBahanBulanIni,
            'persentaseBelanjaBahan' => $persentaseBelanjaBahan,

            'sembakoTerbanyak' => $sembakoTerbanyak[0]->nama,
            'bahanTerbanyak' => $bahanTerbanyak[0]->nama,
            'produkKantinTerbanyak' => $produkKantinTerbanyak[0]->nama,

            'dataKantin' => $dataKantin,
            'dataSembako' => $dataSembako,
            'dataBahan' => $dataBahan,
        ]);
    }
}
