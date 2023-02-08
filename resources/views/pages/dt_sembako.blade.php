@extends('main')

@section('content')
  <div class="flex items-center justify-between mb-5">
    <h1 class="text-xl md:text-3xl text-gray-900 dark:text-white">Grafik Transaksi Belanja Sembako</h1>
    <a href="/sembako/data" class="cursor-pointer rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700">Kelola Data</a>
  </div>

  <span class="inline-block bg-blue-100 text-blue-800 font-medium mb-3 px-2.5 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300">Grafik Ringkasan</span>
  <div class="flex gap-4">
    <div class="basis-3/5 px-4 py-3 rounded-lg bg-white dark:bg-gray-800">
      <p class="text-gray-800 dark:text-gray-200">Nominal Belanja Periode 1 Oktober 2022 - 15 November 2022</p>
    </div>
    <div class="basis-2/5 rounded-lg bg-white h-28 dark:bg-gray-800">
      <p class="text-2xl text-gray-400 dark:text-gray-500">+</p>
    </div>
  </div>

  <span class="inline-block bg-blue-100 text-blue-800 font-medium mt-4 mb-3 px-2.5 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300">Grafik Berdasarkan Filter</span>

@endsection