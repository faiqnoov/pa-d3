@extends('auth.layout')

@section('content')
  <a href="#" class="flex items-center mb-6 text-2xl font-semibold text-gray-900">
    <img class="w-8 h-8 mr-2" src="https://flowbite.s3.amazonaws.com/blocks/marketing-ui/logo.svg" alt="logo">
    Visualize    
  </a>
  <div class="w-full bg-white rounded-lg shadow md:mt-0 sm:max-w-md xl:p-0">
    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
      <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl">
        Register
      </h1>
      <form class="space-y-4 md:space-y-6" action="/register" method="POST">
        @csrf
        <div>
          <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama</label>
          <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" placeholder="Adam Setiawan" required>
        </div>
        <div>
          <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
          <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" placeholder="name@pens.ac.id" required>
        </div>
        <div>
          <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
          <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5" required>
        </div>
        <button type="submit" class="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Daftar</button>
        <p class="text-sm font-light text-gray-500">
          Sudah punya akun? <a href="/login" class="font-medium text-blue-600 hover:underline">Masuk</a>
        </p>
      </form>
    </div>
  </div>
@endsection