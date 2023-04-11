<?php

namespace App\Imports;

use App\Models\Belanja;
use App\Models\Produk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TrxBelanjaSembakoImport implements ToModel, WithHeadingRow
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
        $matchProductId = Produk::where('nama', $row['nama_barang'])->get('id');
        // perlu dicari id subkategori dari nama barang, rawan nyangkut ke nama produk yang sama
        
        if(!$matchProductId->isEmpty()) {
            return new Belanja([
                'id_produk' => $matchProductId[0]->id,
                'tanggal' => $this->date,
                'jumlah' => $row['jumlah'],
                'harga_satuan' => $row['harga_satuan'],
            ]);
        }
    }

    public function headingRow(): int
    {
        return 4;
    }
}
