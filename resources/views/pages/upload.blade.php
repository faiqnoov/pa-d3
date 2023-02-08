@extends('main')

@section('content')
  <h1 class="text-3xl mb-1 text-gray-900 dark:text-white">Import Data</h1>

  <div class="max-w-md bg-white rounded-lg mx-auto mt-16 dark:bg-gray-800">
    <div class="border-b p-2">
      <p class="text-center text-gray-700 dark:text-gray-300 capitalize">
        import data <span class="font-medium">master produk</span>
      </p>
    </div>
    <div class="px-4 py-6">
      <form action="" method="POST">
        <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file">
        <button type="submit" class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-md text-sm px-5 py-2.5 mt-4 mx-auto dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Import</button>
      </form>
    </div>
  </div>
  
@endsection