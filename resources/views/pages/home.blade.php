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
    <a href="/belanja/sembako" class="block h-fit px-4 py-3 rounded-lg bg-white dark:bg-gray-800">
      <p class="font-semibold text-gray-800 dark:text-gray-200">Belanja Sembako</p>
      <canvas id="sembakoChart"></canvas>
    </a>
    
    <div class="h-fit px-4 py-3 rounded-lg bg-white dark:bg-gray-800">
      <p class="font-semibold text-gray-800 dark:text-gray-200">Belanja Bahan Masakan</p>
      <canvas id="bahanmskChart"></canvas>
    </div>
    
    <div class="h-fit px-4 py-3 rounded-lg bg-white dark:bg-gray-800">
      <p class="font-semibold text-gray-800 dark:text-gray-200">Penjualan Produk Kantin</p>
      <canvas id="kantinChart"></canvas>
    </div>
  </div>

@endsection

@section('js')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    // chart penjualan kantin
    let dataKantin = @json($dataKantin);
    let labels1 = Object.keys(dataKantin);
    let data1 = Object.values(dataKantin);

    const crt1 = document.getElementById('kantinChart');

    new Chart(crt1, {
      type: 'line',
      data: {
        labels: labels1,
        datasets: [{
          label: 'Nominal Penjualan',
          data: data1,
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

    // chart belanja sembako
    let dataSembako = @json($dataSembako);
    let labels2 = Object.keys(dataSembako);
    let data2 = Object.values(dataSembako);

    const crt2 = document.getElementById('sembakoChart');

    new Chart(crt2, {
      type: 'line',
      data: {
        labels: labels2,
        datasets: [{
          label: 'Nominal Belanja',
          data: data2,
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