@extends('main')

@section('content')
  <h1 class="text-xl md:text-3xl mb-5 text-gray-900 dark:text-white">Preview Import Data</h1>
  
  <div class="flex gap-4 text-gray-700 dark:text-gray-400">
    <div class="w-64 rounded-lg bg-white py-3 px-4 dark:bg-gray-800">
      <p>Data Diimpor</p>
      <p class="text-xl md:text-2xl font-medium">1.208</p>
    </div>
    <div class="w-64 rounded-lg bg-white py-3 px-4 dark:bg-gray-800">
      <p>Tanggal</p>
      <p class="text-xl md:text-2xl font-medium">2023-01-17</p>
    </div>
  </div>

  <div class="relative overflow-x-auto  rounded-lg mt-5">
    <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400" id="product_table">
      <thead class="bg-gray-50 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
        <tr>
          <th scope="col" class="px-6 py-3">No</th>
          {{-- <th scope="col" class="px-6 py-3">Tanggal</th> --}}
          <th scope="col" class="px-6 py-3">Nama Barang</th>
          <th scope="col" class="px-6 py-3">Jumlah</th>
          <th scope="col" class="px-6 py-3">Satuan</th>
          <th scope="col" class="px-6 py-3">Harga Satuan</th>
          <th scope="col" class="px-6 py-3">Harga Total</th>
          <th scope="col" class="px-6 py-3">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr class="border-t bg-white dark:border-gray-700 dark:bg-gray-800">
          <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">1</th>
          {{-- <td class="px-6 py-4">2023-01-20</td> --}}
          <td class="px-6 py-4">Beras Merah</td>
          <td class="px-6 py-4">10</td>
          <td class="px-6 py-4">buah</td>
          <td class="px-6 py-4">100.000</td>
          <td class="px-6 py-4">1.000.000</td>
          <td class="px-6 py-4">Edit</td>
        </tr>
      </tbody>
    </table>
  </div>
@endsection