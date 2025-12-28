<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function index()
    {
        return view('layouts.auth.index');
    }

    public function loginproses(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            Alert::success('Berhasil', 'Login berhasil')
                ->autoclose(2000)
                ->toToast()
                ->timerProgressBar();
            return redirect()->route('dashboard');  
        }
        
        Alert::error('Gagal', 'Email atau password salah')
            ->autoclose(2000)
            ->toToast()
            ->timerProgressBar();
        return redirect()->route('login')->withInput($request->only('email'));
    }

    public function registerproses(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_mahasiswa' => 1,
        ]);

        // Auth::login($user);
        // Alert::success('Berhasil', 'Register berhasil')
        //     ->autoclose(2000)
        //     ->toToast()
        //     ->timerProgressBar();
        // return redirect()->route('mahasiswa.create');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
