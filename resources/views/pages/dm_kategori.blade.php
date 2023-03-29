@extends('main')

@section('content')
  <div class="flex items-center justify-between mb-5">
    <h1 class="text-xl md:text-3xl text-gray-900 dark:text-white">Data Master Kategori</h1>
    <a href="/upload" class="cursor-pointer rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700">Tambah Kategori</a>
  </div>

  <div class="flex gap-4 text-gray-700 dark:text-gray-100">
    <div class="w-64 rounded-lg bg-white py-3 px-4 dark:bg-gray-800">
      <p>Jumlah Subkategori</p>
      <p class="text-xl md:text-2xl font-medium">{{ $jmlSubkategori }}</p>
    </div>
    <div class="w-64 rounded-lg bg-white py-3 px-4 dark:bg-gray-800">
      <p>Terakhir Diperbarui</p>
      <p class="text-xl md:text-2xl font-medium">2023-01-17</p>
    </div>
  </div>

  <div class="relative overflow-x-auto w-fit rounded-lg mt-5">
    <table class="text-left text-sm text-gray-700 dark:text-gray-100">
      <thead class="bg-gray-50 text-xs uppercase dark:bg-gray-700">
        <tr>
          <th scope="col" class="px-6 py-3">No</th>
          <th scope="col" class="px-6 py-3">Kategori</th>
          <th scope="col" class="px-6 py-3">Subkategori</th>
          <th scope="col" class="px-6 py-3">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($subkategoris as $subkategori)
          <tr class="border-t bg-white dark:border-gray-700 dark:bg-gray-800">
            <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium">{{ $loop->iteration }}</th>
            <td class="px-6 py-4">{{ $subkategori->kategori->nama }}</td>
            <td class="px-6 py-4">{{ $subkategori->nama }}</td>
            <td class="px-6 py-4">Edit</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection