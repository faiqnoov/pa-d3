<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Kategori;
use App\Models\Produk;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Kategori::create([
            'nama' => 'Sembako',
        ]);
        
        Kategori::create([
            'nama' => 'Bahan Masakan',
        ]);

        Produk::create([
            'id_kategori' => 1,
            'nama' => 'Sugar',
            'keterangan' => 'Satuan',
            'satuan' => 'kg',
            'merek' => 'Gulaque',
            'harga_beli' => 12000,
        ]);
    }
}
