@extends('main')

@section('content')
  <div class="mb-4">
    <h1 class="text-3xl mb-1 text-gray-900 dark:text-white">Home</h1>
    <div class="flex items-center text-gray-900 dark:text-gray-400">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m3.75 2.383a14.406 14.406 0 01-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 10-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
      </svg>
      <p class="ml-1">Ringkasan pemasukan dan pengeluaran setiap jenis data</p>
    </div>
  </div>
  <div class="grid grid-cols-2 gap-4">
    <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
      <p class="text-2xl text-gray-400 dark:text-gray-500">+</p>
    </div>
    <div class="flex items-center justify-center rounded bg-gray-50 h-28 dark:bg-gray-800">
      <p class="text-2xl text-gray-400 dark:text-gray-500">+</p>
    </div>
  </div>
@endsection