@extends('main')

@section('content')
  <div class="flex items-center justify-between mb-5">
    <h1 class="text-xl md:text-3xl text-gray-900 dark:text-white">Grafik Belanja Bahan Masakan</h1>
    <a href="/belanja/bahan/data" class="cursor-pointer rounded-lg bg-blue-700 px-5 py-2.5 text-sm font-medium text-white hover:bg-blue-800 dark:bg-blue-600 dark:hover:bg-blue-700">Kelola Data</a>
  </div>

  <span class="inline-block bg-blue-100 text-blue-800 font-medium mb-3 px-2.5 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300">Grafik Ringkasan</span>
  <div class="flex gap-4">
    <div class="basis-2/3 h-fit px-4 py-3 rounded-lg bg-white dark:bg-gray-800">
      <p class="font-semibold text-gray-800 dark:text-gray-200">Nominal Belanja {{ $tglAwalRingkasan }} s.d. {{ $tglAkhirRingkasan }}</p>
      <canvas id="resumeChart"></canvas>
    </div>
    <div class="basis-1/3 h-fit px-4 py-3 rounded-lg bg-white dark:bg-gray-800">
      <p class="font-semibold text-center text-gray-800 dark:text-gray-200">5 Barang Paling Banyak Dibeli</p>
      <canvas id="rankedChart"></canvas>
    </div>
  </div>



  <span class="inline-block bg-blue-100 text-blue-800 font-medium mt-4 mb-3 px-2.5 py-1 rounded-full dark:bg-blue-900 dark:text-blue-300">Grafik Berdasarkan Filter</span>
  <div class="flex gap-4">
    <div class="basis-2/3 h-fit px-4 py-3 rounded-lg bg-white dark:bg-gray-800">
      <p class="font-semibold text-gray-800 dark:text-gray-200">
        @if (request('tipe') == 'jumlah')
          Jumlah Belanja
        @else
          Harga Satuan
        @endif

        @if (request('barang1') && request('barang2'))
          {{ $barangTrend }} & {{ $barangTrend2 }}
        @elseif (request('barang1'))
          {{ $barangTrend }}
        @elseif (request('barang2'))
          {{ $barangTrend2 }}
        @else
          Pilih barang terlebih dahulu!
        @endif

        @if (request('barang1') || request('barang2'))
          Periode {{ $tglAwalFilter }} - {{ $tglAkhirFilter }}
        @endif
      </p>
      @if (request('barang1') || request('barang2'))
        <canvas id="filteredChart"></canvas>
      @endif
    </div>
    <div class="basis-1/3 h-fit px-4 py-3 rounded-lg bg-white dark:bg-gray-800">
      <p class="font-semibold text-center text-gray-800 dark:text-gray-200">Filter Data</p>
      <form action="/belanja/bahan">
        <div>
          <div>
            <label for="barang1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Barang 1</label>
            <select id="barang1" name="barang1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
              <option value="">-</option>
              @foreach ($bahans as $bahan)
                <option value="{{ $bahan->id }}" @if ($bahan->id == request('barang1')) selected @endif>
                  {{ $bahan->nama }}
                </option>
              @endforeach
            </select>
          </div>
          <div>
            <label for="barang2" class="block mt-3 mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih Barang 2</label>
            <select id="barang2" name="barang2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white">
              <option value="">-</option>
              @foreach ($bahans as $bahan)
                <option value="{{ $bahan->id }}" @if ($bahan->id == request('barang2')) selected @endif>
                  {{ $bahan->nama }}
                </option>
              @endforeach
            </select>
          </div>
          <div>
            <label for="tgl-awal" class="block mt-3 mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Awal</label>
            <input type="date" id="tgl-akhir" name="tgl-awal" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" @if(request('tgl-awal')) value="{{ request('tgl-awal') }}" @endif>
          </div>
          <div>
            <label for="tgl-akhir" class="block mt-3 mb-2 text-sm font-medium text-gray-900 dark:text-white">Tanggal Akhir</label>
            <input type="date" id="tgl-akhir" name="tgl-akhir" class="block w-full p-2 text-gray-900 border border-gray-300 rounded-lg bg-gray-50 text-sm dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" @if(request('tgl-akhir')) value="{{ request('tgl-akhir') }}" @endif>
          </div>
          <div>
            <p class="mt-3 mb-2 text-sm font-medium text-gray-900 dark:text-white">Filter Berdasarkan</p>
            <div class="flex items-center">
              <input id="filter-option-1" type="radio" name="tipe" value="jumlah" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600" @if(request('tipe') == 'jumlah') checked @endif>
              <label for="filter-option-1" class="block ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Jumlah Beli</label>
            </div>
            <div class="flex items-center">
              <input id="filter-option-2" type="radio" name="tipe" value="harga_satuan" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600" @if(request('tipe') == 'harga_satuan') checked @endif>
              <label for="filter-option-2" class="block ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Harga Satuan</label>
            </div>
          </div>
          <button type="submit" class="block px-3 py-2 mt-3 mx-auto text-xs font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Terapkan</button>
        </div>
      </form>
    </div>
  </div>

@endsection

@section('js')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <script>
    // chart ringkasan
    let totals = @json($totals);
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

    // chart ranking
    let ranks = @json($ranks);
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

    // chart filter
    let trends = @json($trends);
    let labels3 = Object.keys(trends);
    let data3 = Object.values(trends);
    let trendsProduct = @json($barangTrend);
    
    let trends2 = @json($trends2);
    let data4 = Object.values(trends2);
    let trendsProduct2 = @json($barangTrend2);

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

  </script>
@endsection