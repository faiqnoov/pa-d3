@extends('export.layout')

@section('content')
  <div class="flex justify-end">
    <button id="btn-export" type="button" class="print:hidden text-white bg-blue-700 mt-4 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 -ml-1">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" /></svg>      
      Export
    </button>
  </div>
  <h1 class="text-xl text-center md:text-3xl text-gray-900 dark:text-white">Laporan Grafik Belanja Sembako</h1>

  <span id="wkwkw" class="inline-block bg-blue-100 text-blue-800 font-medium mb-3 px-2.5 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300">Grafik Ringkasan</span>
  <div class="flex gap-4">
    <div class="basis-1/2 h-fit px-4 py-3 rounded-lg bg-white dark:bg-gray-800">
      <p class="font-semibold text-gray-800 dark:text-gray-200">Nominal Belanja <span id="tglAwal"></span> s.d. <span id="tglAkhir"></span></p>
      <canvas id="resumeChart"></canvas>
    </div>
    <div class="basis-1/2 h-fit px-4 py-3 rounded-lg bg-white dark:bg-gray-800">
      <p class="font-semibold text-gray-800 dark:text-gray-200">5 Barang Paling Banyak Dibeli</p>
      <canvas id="rankedChart"></canvas>
    </div>
  </div>

@endsection

@section('js')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>

  <script type="module">
    $(document).ready(function(){
      $.ajax({
        url: "/export/sembako",
        type: "GET",
        dataType: 'json',
        success: function(data) {
          generateChartRingkasan(data.totals);
          $('#tglAwal').text(data.tglAwalRingkasan);
          $('#tglAkhir').text(data.tglAkhirRingkasan);
          generateChartRanking(data.ranks);
        }
      })
    });

    // chart ringkasan
    function generateChartRingkasan(totals) {
      let labels1 = Object.keys(totals);
      let data1 = Object.values(totals);
  
      const crt1 = document.getElementById('resumeChart');
  
      new Chart(crt1, {
        type: 'bar',
        data: {
          labels: labels1,
          datasets: [{
            label: 'Total Belanja',
            data: data1,
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
    }

    // chart ranking
    function generateChartRanking(ranks) {
      let labels2 = Object.keys(ranks);
      let data2 = Object.values(ranks);
      
      const crt2 = document.getElementById('rankedChart');
  
      new Chart(crt2, {
        type: 'bar',
        data: {
          labels: labels2,
          datasets: [{
            label: 'Jumlah Item',
            data: data2,
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
    }

    $('#btn-export').click(function() {
      window.print();
    });

  </script>
@endsection