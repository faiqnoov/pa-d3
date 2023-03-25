@extends('main')

@section('content')
  <div class="flex items-center justify-between mb-5">
    <h1 class="text-xl md:text-3xl text-gray-900 dark:text-white">Data Transaksi Belanja Sembako</h1>
    <button data-modal-target="importdata-modal" data-modal-toggle="importdata-modal" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
      Import Data Baru
    </button>
  </div>

  <div class="flex gap-4 text-gray-700 dark:text-gray-100">
    <div class="w-64 rounded-lg bg-white py-3 px-4 dark:bg-gray-800">
      <p>Jumlah Transaksi</p>
      <p class="text-xl md:text-2xl font-medium">1.208</p>
    </div>
    <div class="w-64 rounded-lg bg-white py-3 px-4 dark:bg-gray-800">
      <p>Data Terbaru</p>
      <p class="text-xl md:text-2xl font-medium">2023-01-17</p>
    </div>
  </div>

  <div class="relative overflow-x-auto  rounded-lg mt-5">
    <table class="w-full text-left text-sm text-gray-700 dark:text-gray-100">
      <thead class="bg-gray-50 text-xs uppercase dark:bg-gray-700">
        <tr>
          <th scope="col" class="px-6 py-3">No</th>
          <th scope="col" class="px-6 py-3">Tanggal</th>
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
          <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium">1</th>
          <td class="px-6 py-4">2023-01-20</td>
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

  <!-- Main modal -->
  <div id="importdata-modal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
      <div class="relative w-full h-full max-w-md md:h-auto">
          <!-- Modal content -->
          <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
              <button type="button" class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" data-modal-hide="importdata-modal">
                  <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                  <span class="sr-only">Close modal</span>
              </button>
              <div class="px-6 py-6 lg:px-8">
                  <h3 class="mb-4 text-xl font-medium text-gray-900 dark:text-white capitalize">import data belanja sembako</h3>
                  <form class="space-y-6" action="#" method="POST">
                    <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file">
                    <button type="submit" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Import</button>
                  </form>
              </div>
          </div>
      </div>
  </div> 
@endsection