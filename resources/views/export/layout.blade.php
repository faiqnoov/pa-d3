<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/css/app.css','resources/js/app.js'])
  
  <title>Export Visualisasi Data</title>
</head>
<body>
  <div class="bg-[#F5F3F6]">
    @yield('content')
    @yield('js')
  </div>
</body>
</html>