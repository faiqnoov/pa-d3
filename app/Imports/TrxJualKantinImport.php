<?php

namespace App\Imports;

use App\Models\Penjualan;
use App\Models\Produk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

HeadingRowFormatter::default('none');

class TrxJualKantinImport implements ToModel, WithHeadingRow
{
    protected $date;

    function __construct($date) {
        $this->date = $date;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $matchProductId = Produk::where('nama', $row['Nama Produk'])->get('id');
        
        if(!$matchProductId->isEmpty()) {
            $explodedJumlah = explode(' ', $row['Jumlah Produk Terjual (Unit)']);

            return new Penjualan([
                'id_produk' => $matchProductId[0]->id,
                'jumlah' => $explodedJumlah[0],
                'penjualan_kotor' => $row['Penjualan Kotor'],
                'tanggal' => $this->date
            ]);
        }
    }

    public function headingRow(): int
    {
        return 5;
    }
}
