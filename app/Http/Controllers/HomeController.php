<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
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
            'dataKantin' => $dataKantin,
            'dataSembako' => $dataSembako,
        ]);
    }
}
