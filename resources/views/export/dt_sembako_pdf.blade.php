@extends('export.layout')

@section('content')
  <div class="flex justify-end">
    <button id="btn-export" type="button" class="print:hidden text-white bg-blue-700 mt-4 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center mr-2">
      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2 -ml-1">
        <path stroke-linecap="round" stroke-linejoin="round" d="M9 8.25H7.5a2.25 2.25 0 00-2.25 2.25v9a2.25 2.25 0 002.25 2.25h9a2.25 2.25 0 002.25-2.25v-9a2.25 2.25 0 00-2.25-2.25H15m0-3l-3-3m0 0l-3 3m3-3V15" /></svg>      
      PDF
    </button>
  </div>
  <h1 class="text-xl text-center md:text-3xl text-gray-900">Laporan Grafik Belanja Sembako</h1>

  <span id="wkwkw" class="inline-block bg-blue-100 text-blue-800 font-medium mb-3 px-2.5 py-1 rounded-full">Grafik Ringkasan</span>
  <div class="flex gap-4">
    <div class="basis-1/2 h-fit px-4 py-3 rounded-lg bg-white">
      <p class="font-semibold text-gray-800">Nominal Belanja <span id="tglAwal"></span> s.d. <span id="tglAkhir"></span></p>
      <canvas id="resumeChart"></canvas>
    </div>
    <div class="basis-1/2 h-fit px-4 py-3 rounded-lg bg-white">
      <p class="font-semibold text-gray-800">5 Barang Paling Banyak Dibeli</p>
      <canvas id="rankedChart"></canvas>
    </div>
  </div>

  <span class="inline-block bg-blue-100 text-blue-800 font-medium mt-4 mb-3 px-2.5 py-1 rounded-full">Grafik Berdasarkan Filter</span>
  <div class="flex justify-center">
    <div class="basis-1/2 h-fit px-4 py-3 rounded-lg bg-white">
      <canvas id="filteredChart"></canvas>
    </div>
  </div>

@endsection

@section('js')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script type="module">
    // get data from url
    let urlParams = new URLSearchParams(window.location.search);
    let serializedData = urlParams.get('data');
    let chartFilterData = JSON.parse(decodeURIComponent(serializedData));

    $(document).ready(function(){
      $.ajax({
        url: "/getdata/sembako",
        type: "GET",
        dataType: 'json',
        success: function(data) {
          generateChartRingkasan(data.totals);
          $('#tglAwal').text(data.tglAwalRingkasan);
          $('#tglAkhir').text(data.tglAkhirRingkasan);
          generateChartRanking(data.ranks);
        }
      });

      generateChartFilter(chartFilterData.trends, chartFilterData.barangTrend, chartFilterData.trends2, chartFilterData.barangTrend2);
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

    // chart filter
    function generateChartFilter(trends, barangTrend, trends2, barangTrend2) {
      let labels3 = Object.keys(trends);
      let data3 = Object.values(trends);
      let trendsProduct = barangTrend;
      
      let data4 = Object.values(trends2);
      let trendsProduct2 = barangTrend2;
  
      const crt3 = document.getElementById('filteredChart');
  
      new Chart(crt3, {
        type: 'line',
        data: {
          labels: labels3,
          datasets: [
            {
              label: trendsProduct,
              data: data3,
              borderWidth: 1
            },
            {
              label: trendsProduct2,
              data: data4,
              borderWidth: 1
            },
          ]
        },
        options: {
          scales: {
            y: {
              beginAtZero: false
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