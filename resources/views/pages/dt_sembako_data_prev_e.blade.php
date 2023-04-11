{{-- @dd($belanja) --}}
@extends('main')

@section('content')
  <h1 class="text-xl md:text-3xl mb-5 text-gray-900 dark:text-white">Edit Data</h1>
  
  <div class="w-64 px-4 py-3 rounded-lg bg-white dark:bg-gray-800">
    <form action="/belanja/sembako/{{ $belanja->id }}" method="post">
      @csrf
      <div class="mb-4">
        <label for="nama" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Produk</label>
        <input type="text" id="nama" name="nama" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cursor-not-allowed" value="{{ $belanja->produk->nama }}" disabled readonly>
      </div>
      <div class="mb-4">
        <label for="jumlah" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Jumlah</label>
        <input type="number" id="jumlah" name="jumlah" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ old('jumlah', $belanja->jumlah) }}" required>
      </div>
      <div class="mb-4">
        <label for="harga_satuan" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Harga Satuan</label>
        <input type="number" id="harga_satuan" name="harga_satuan" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="{{ old('harga_satuan', $belanja->harga_satuan) }}" required>
      </div>
      <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2 block mx-auto text-center dark:bg-blue-600 dark:hover:bg-blue-700">Simpan</button>
    </form>
  </div>

@endsection