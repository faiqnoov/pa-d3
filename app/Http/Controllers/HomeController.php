<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // -- insight
        $nominalPenjualan = DB::table('penjualans')->select(DB::raw('SUM(penjualan_kotor) as total_penjualan, tanggal'))
                    // ->whereMonth('tanggal', date('01'))
                    // ->whereYear('tanggal', date('2023'))
                    ->groupBy('tanggal')
                    ->orderBy('tanggal', 'desc')
                    ->limit(2)
                    ->get();

        $penjualanBulanIni = $nominalPenjualan[0]->total_penjualan;
        $penjualanBulanLalu = $nominalPenjualan[1]->total_penjualan;

        $selisihPenjualan = $penjualanBulanIni - $penjualanBulanLalu;
        $persentasePenjualan = round(($selisihPenjualan / $penjualanBulanLalu) * 100);

        // --
        $nominalBelanjaSembako = DB::table('belanjas')->select(DB::raw('SUM(harga_satuan*jumlah) AS total_belanja, tanggal'))
                    // ->whereMonth('tanggal', date('01'))
                    // ->whereYear('tanggal', date('2023'))
                    ->groupBy('tanggal')
                    ->orderBy('tanggal', 'desc')
                    ->limit(2)
                    ->get();
        
        $belanjaSembakoBulanIni = $nominalBelanjaSembako[0]->total_belanja;
        $belanjaSembakoBulanLalu = $nominalBelanjaSembako[1]->total_belanja;

        $selisihBelanjaSembako = $belanjaSembakoBulanIni - $belanjaSembakoBulanLalu;
        $persentaseBelanjaSembako = round(($selisihBelanjaSembako / $belanjaSembakoBulanLalu) * 100);

        // --
        // ga akurat, karena satuan beda2
        $sembakoTerbanyak = DB::table('belanjas')
                    ->join('produks', 'belanjas.id_produk', '=', 'produks.id')
                    ->select(DB::raw('belanjas.tanggal, belanjas.jumlah, produks.nama'))
                    ->groupBy('belanjas.id_produk', 'belanjas.tanggal')
                    ->orderBy('jumlah', 'desc')
                    ->limit(1)
                    ->get();
        
        // 
        $penjualanKantinTerbanyak = DB::table('penjualans')
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
        $getDataSembako = DB::table('belanjas')->select(DB::raw('SUM(harga_satuan*jumlah) AS total_belanja, tanggal'))
                    ->groupBy('tanggal')
                    ->orderBy('tanggal')
                    ->limit(6)
                    ->get();

        $dataSembako = $getDataSembako->mapWithKeys(function ($item, $key) {
            return [$item->tanggal => $item->total_belanja];
        });

        return view('pages.home', [
            'penjualanBulanIni' => $penjualanBulanIni,
            'persentasePenjualan' => $persentasePenjualan,
            'belanjaSembakoBulanIni' => $belanjaSembakoBulanIni,
            'persentaseBelanjaSembako' => $persentaseBelanjaSembako,
            'sembakoTerbanyak' => $sembakoTerbanyak[0]->nama,
            'penjualanKantinTerbanyak' => $penjualanKantinTerbanyak[0]->nama,

            'dataKantin' => $dataKantin,
            'dataSembako' => $dataSembako,
        ]);
    }
}
