@extends('main')

@section('content')
  <div class="flex items-center justify-between mb-5">
    <h1 class="text-xl md:text-3xl text-gray-900 dark:text-white">Data Master Produk</h1>
    <a href="/upload" class="cursor-pointer rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700">Import Data Baru</a>
  </div>

  <div class="flex gap-4 text-gray-700 dark:text-gray-400">
    <div class="w-64 rounded-lg bg-white py-3 px-4 dark:bg-gray-800">
      <p>Jumlah Produk</p>
      <p class="text-xl md:text-2xl font-medium">127</p>
    </div>
    <div class="w-64 rounded-lg bg-white py-3 px-4 dark:bg-gray-800">
      <p>Terakhir Diperbarui</p>
      <p class="text-xl md:text-2xl font-medium">2023-01-17</p>
    </div>
  </div>

  <div class="relative overflow-x-auto rounded-lg mt-5">
    <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400" id="product_table">
      <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th scope="col" class="px-6 py-3">No</th>
          <th scope="col" class="px-6 py-3">Kategori</th>
          <th scope="col" class="px-6 py-3">Nama Barang</th>
          <th scope="col" class="px-6 py-3">Keterangan</th>
          <th scope="col" class="px-6 py-3">Satuan</th>
          <th scope="col" class="px-6 py-3">Merek</th>
          <th scope="col" class="px-6 py-3">Harga Jual</th>
          <th scope="col" class="px-6 py-3">Harga Beli</th>
          <th scope="col" class="px-6 py-3">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr class="border-t bg-white dark:border-gray-700 dark:bg-gray-800">
          <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">1</th>
          <td class="px-6 py-4">Sembako</td>
          <td class="px-6 py-4">Beras Merah</td>
          <td class="px-6 py-4">1 karung 25kg</td>
          <td class="px-6 py-4">buah</td>
          <td class="px-6 py-4"></td>
          <td class="px-6 py-4"></td>
          <td class="px-6 py-4"></td>
          <td class="px-6 py-4">Edit</td>
        </tr>
      </tbody>
    </table>
  </div>
@endsection
