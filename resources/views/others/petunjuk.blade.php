@extends('main')

@section('content')
  <h1 class="text-xl md:text-3xl mb-5 text-gray-900 dark:text-white">Petunjuk Penggunaan</h1>

  <div class="h-fit px-4 py-3 rounded-lg bg-white dark:bg-gray-800">
    
    <div id="accordion-collapse" data-accordion="collapse">
      <h2 id="accordion-collapse-heading-1">
        <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-1" aria-expanded="true" aria-controls="accordion-collapse-body-1">
          <span>Import file spreadsheet untuk data master</span>
          <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
      </h2>
      <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
        <div class="p-5 border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
          {{-- <p class="mb-2 text-gray-500 dark:text-gray-400"></p> --}}
          <ul class="pl-5 text-gray-500 list-disc dark:text-gray-400">
            <li>Import data master hanya perlu dilakukan satu kali saja.</li>
            <li>Nama dan ID dari data ini akan digunakan sebagai acuan untuk data transaksi, jadi sebisa mungkin untuk tidak melakukan perubahan data pada data master</li>
          </ul>
        </div>
      </div>
      <h2 id="accordion-collapse-heading-3">
        <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-3" aria-expanded="false" aria-controls="accordion-collapse-body-3">
          <span>Import file spreadsheet untuk data transaksi</span>
          <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        </button>
      </h2>
      <div id="accordion-collapse-body-3" class="hidden" aria-labelledby="accordion-collapse-heading-3">
        <div class="p-5 border border-t-0 border-gray-200 dark:border-gray-700">
          <ul class="pl-5 text-gray-500 list-disc dark:text-gray-400">
            <li>Data transaksi dapat dilakukan dengan melakukan import file spreadsheet dengan menyesuaikan template file yang telah tersedia pada modal import data</li>
            <li>Pastikan format penamaan file sesuai dengan ketentuan agar tanggal yang tercatat pada database sesuai dengan tanggal pada nama dile</li>
            <li>Import data transaksi dapat dilakukan berkali-kali sesuai dengan kebutuhan</li>
            
          </ul>
        </div>
      </div>
    </div>

  </div>  
@endsection