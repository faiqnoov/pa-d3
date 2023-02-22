<?php

namespace App\Imports;

use App\Models\Kategori;
use App\Models\Produk;
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
        $isCategoryExist = Kategori::where('nama', $row['kategori'])->exists();

        if(!$isCategoryExist) {
            return new Kategori([
                'nama' => $row['kategori'],
            ]);
        }
        
        $isProductExist = Produk::where('nama', $row['nama_produk'])->exists();
        
        if(!$isProductExist) {
            $matchCategoryId = Kategori::where('nama', $row['kategori'])->get('id');
            return new Produk([
                'id_kategori' => $matchCategoryId[0]->id,
                'nama' => $row['nama_produk'],
                'merek' => $row['merek'],
                'harga_jual' => $row['harga_jual'],
                'harga_beli' => $row['harga_beli'],
            ]);
        }
    }
}
