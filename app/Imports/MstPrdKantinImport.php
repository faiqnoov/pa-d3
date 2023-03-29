<?php

namespace App\Imports;

use App\Models\Produk;
use App\Models\Subkategori;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MstPrdKantinImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $isSubcategoryExist = Subkategori::where('nama', $row['kategori'])->exists();

        if(!$isSubcategoryExist) {
            return new Subkategori([
                'id_kategori' => 1,
                'nama' => $row['kategori'],
            ]);
        }
        
        $isProductExist = Produk::where('nama', $row['nama_produk'])->exists();
        
        if(!$isProductExist) {
            $matchSubcategoryId = Subkategori::where('nama', $row['kategori'])->get('id');
            return new Produk([
                'id_subkategori' => $matchSubcategoryId[0]->id,
                'nama' => $row['nama_produk'],
                'merek' => $row['merek'],
                'harga_jual' => $row['harga_jual'],
                'harga_beli' => $row['harga_beli'],
            ]);
        }
    }
}
