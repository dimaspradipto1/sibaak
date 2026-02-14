<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class SettingsController extends Controller
{
    public function index()
    {
        $title = 'Pengaturan Akun';
        return view('pages.settings.index', compact('title'));
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            // 'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);

        $user = Auth::user();



        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        Alert::success('Berhasil', 'Password berhasil diperbarui')->autoclose(3000)->toToast();
        return redirect()->route('settings.index');
    }
}
