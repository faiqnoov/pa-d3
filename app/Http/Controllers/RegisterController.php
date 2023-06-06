<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('auth.register');
    }

    public function store(Request $request)
    {
        // validate data
        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            // 'password_confirm' => 'required|same:password',
        ]);

        // encrypt password using Hash
        $validatedData['password'] = Hash::make($validatedData['password']);

        // create user
        $user = User::create($validatedData);

        return redirect('/user')->with('success', 'Registrasi Berhasil! Akun baru telah ditambahkan.');
    }
}
