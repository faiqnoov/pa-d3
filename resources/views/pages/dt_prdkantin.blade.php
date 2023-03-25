@extends('main')

@section('content')
  <div class="flex items-center justify-between mb-5">
    <h1 class="text-xl md:text-3xl text-gray-900 dark:text-white">Grafik Penjualan Produk Kantin</h1>
    <a href="/penjualan/kantin/data" class="cursor-pointer rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700">Kelola Data</a>
  </div>

  <span class="inline-block bg-blue-100 text-blue-800 font-medium mb-3 px-2.5 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300">Grafik Ringkasan</span>
  <div class="flex gap-4">
    <div class="basis-2/3 h-fit px-4 py-3 rounded-lg bg-white dark:bg-gray-800">
      <p class="font-semibold text-gray-800 dark:text-gray-200">Nominal Penjualan Kantin 1 Oktober 2022 - 15 November 2022</p>
      <canvas id="resumeChart"></canvas>
    </div>
    <div class="basis-1/3 h-fit px-4 py-3 rounded-lg bg-white dark:bg-gray-800">
      <p class="font-semibold text-center text-gray-800 dark:text-gray-200">5 Barang dengan Jumlah Penjualan Terbanyak</p>
      <canvas id="sortedChart"></canvas>
    </div>
  </div>

  <span class="inline-block bg-blue-100 text-blue-800 font-medium mt-4 mb-3 px-2.5 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300">Grafik Berdasarkan Filter</span>
  <div class="flex gap-4">
    <div class="basis-2/3 h-fit px-4 py-3 rounded-lg bg-white dark:bg-gray-800">
      <p class="font-semibold text-gray-800 dark:text-gray-200">Jumlah Penjualan Air Mineral 1 Oktober 2022 - 15 November 2022</p>
      <canvas id="filteredChart"></canvas>
    </div>
    <div class="basis-1/3 h-fit px-4 py-3 rounded-lg bg-white dark:bg-gray-800">
      <p class="font-semibold text-center text-gray-800 dark:text-gray-200">Filter Data</p>
      <div>
        <div>
          <label for="barang" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Barang</label>
          <select id="barang" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
            <option>Air Mineral</option>
            <option>Nasi</option>
            <option>Sayur</option>
          </select>
        </div>
        <div>
          <label for="tgl-mulai" class="block mt-3 mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Mulai</label>
          <input type="date" id="tgl-mulai" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
        </div>
        <div>
          <label for="tgl-selesai" class="block mt-3 mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Selesai</label>
          <input type="date" id="tgl-selesai" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
        </div>
        <div>
          <p class="mt-3 mb-2 text-sm font-medium text-gray-900 dark:text-white">Filter Berdasarkan</p>
          <div class="flex items-center">
            <input id="country-option-1" type="radio" name="countries" value="USA" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600" checked>
            <label for="country-option-1" class="block ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Jumlah Penjualan</label>
          </div>
        </div>
        <button type="button" class="block px-3 py-2 mt-3 mx-auto text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Terapkan</button>
      </div>
    </div>
  </div>
@endsection

@section('js')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
  <script>
    const ctx = document.getElementById('resumeChart');

    // const data = [
    //   {date: 2022-11-30, totalNominal: 120000000}
    // ];
    // how to get total nominal amount from every single date?

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
        datasets: [{
          label: 'Nominal Penjualan',
          data: [120000000, 110000000, 98000000, 117000000, 105000000, 127000000],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: false
          }
        }
      }
    });

    const crt2 = document.getElementById('sortedChart');

    new Chart(crt2, {
      type: 'bar',
      data: {
        labels: ['Air Mineral', 'Nasi', 'Ayam', 'Sayur', 'Mie'],
        datasets: [{
          label: 'Item Terjual',
          data: [1200, 998, 800, 729, 602],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });

    const crt3 = document.getElementById('filteredChart');

    new Chart(crt3, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei'],
        datasets: [{
          label: 'Jumlah Item Terjual',
          data: [3619, 3000, 3200, 2900, 3300],
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: false
          }
        }
      }
    });

  </script>
@endsection