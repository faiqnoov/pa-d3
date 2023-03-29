<?php

namespace App\Imports;

use App\Models\Produk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class MstSembakoImport implements ToModel, WithHeadingRow, WithMultipleSheets
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Produk([
            'id_subkategori' => 1,
            'nama' => $row['nama_barang'],
            'keterangan' => $row['keterangan'],
            'satuan' => $row['satuan'],
        ]);
    }

    public function headingRow(): int
    {
        return 4;
    }

    public function sheets(): array
    {
        return [
            'Sembako' => new MstSembakoImport(),
        ];
    }
}
