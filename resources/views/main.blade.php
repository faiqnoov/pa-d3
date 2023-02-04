<!DOCTYPE html>
<html lang="en" class="">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @vite(['resources/css/app.css','resources/js/app.js'])
  
  <title>Visualize</title>
</head>
<body class="dark:bg-[#101827]">
  
  @include('partials.sidebar')

  <div class="p-4 sm:ml-64 mt-14">
    @yield('content')
  </div>

</body>
</html>