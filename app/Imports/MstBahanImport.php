<?php

namespace App\Imports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MstBahanImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Produk([
            'id_subkategori' => 2,
            'nama' => $row['nama_barang'],
            'keterangan' => $row['keterangan'],
            'satuan' => $row['satuan'],
        ]);
    }

    public function headingRow(): int
    {
        return 3;
    }
}
