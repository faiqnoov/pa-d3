<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Produk;
use App\Models\Belanja;
use App\Models\Kategori;
use App\Models\Penjualan;
use App\Models\Subkategori;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin KDH',
            'email' => 'adminkdh@pens.ac.id',
            'password' => Hash::make('qwe123'),
        ]);

        Kategori::create([
            'nama' => 'Makanan',
        ]);

        Kategori::create([
            'nama' => 'Minuman',
        ]);
        
        Subkategori::create([
            'id_kategori' => 1,
            'nama' => 'Sembako',
        ]);
        
        Subkategori::create([
            'id_kategori' => 1,
            'nama' => 'Bahan Masakan',
        ]);

        Produk::create([
            'id_subkategori' => 1,
            'nama' => 'Sugar',
            'keterangan' => 'Satuan',
            'satuan' => 'kg',
            'merek' => 'Gulaque',
            'harga_beli' => 12000,
        ]);

        Belanja::create([
            'id_produk' => 1,   // ganti manual
            'tanggal' => '2023-03-31',
            'jumlah' => 50,
            'harga_satuan' => 9000
        ]);

        Penjualan::create([
            'id_produk' => 1,
            'tanggal' => '2023-02-28',
            'jumlah' => 7,
            'penjualan_kotor' => 49000
        ]);
    }
}
