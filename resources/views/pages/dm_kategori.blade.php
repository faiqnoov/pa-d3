@extends('main')

@section('content')
  <div class="flex items-center justify-between mb-5">
    <h1 class="text-xl md:text-3xl text-gray-900 dark:text-white">Data Master Kategori</h1>
  </div>

  <div class="flex justify-between">
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

    <form>
      <div class="relative mt-5">
        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
            <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>
        <input type="search" id="kategori-search" name="kategori-search" class="block max-w-3xl px-4 py-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
      </div>
    </form>
  </div>


  <div class="relative overflow-x-auto w-fit rounded-lg mt-4">
    <table class="text-left text-sm text-gray-700 dark:text-gray-100">
      <thead class="bg-gray-50 text-xs uppercase dark:bg-gray-700">
        <tr>
          <th scope="col" class="px-6 py-3">No</th>
          <th scope="col" class="px-6 py-3">Kategori</th>
          <th scope="col" class="px-6 py-3">Subkategori</th>
        </tr>
      </thead>
      <tbody id="filteredTable">
        
      </tbody>
    </table>
  </div>
@endsection

@section('js')
<script type="module">
  
  $(document).ready(function(){
    $.ajax({
      url: "/kategori/load",
      type: "GET",
      dataType: 'json',
      success: function(data) {
        showCategories(data);
      }
    })
  });

  function showCategories(data) {
    $.each(data, function(index, value) {
      // console.log(value);
      $('#filteredTable').append(`
        <tr class="border-t bg-white dark:border-gray-700 dark:bg-gray-800">
          <th scope="row" class="whitespace-nowrap px-6 py-4 font-medium">${index+1}</th>
          <td class="px-6 py-4">${value.kategori}</td>
          <td class="px-6 py-4">${value.subkategori}</td>
        </tr>
      `);
    });
  }

  // search
  $('#kategori-search').on('keyup', function(e) {
    e.preventDefault();  // why stil reload the page?

    var formData = $(this).val();
    $.ajax({
      url: "/kategori/search",
      type: "GET",
      data: 'keyword=' + formData,
      dataType: 'json',
      success: function(data) {
        $('#filteredTable').empty();
        showCategories(data);
      }
    });
  });
  
  
</script>
@endsection