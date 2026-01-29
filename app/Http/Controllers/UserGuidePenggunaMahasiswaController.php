<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserGuideMahasiswa;

class UserGuidePenggunaMahasiswaController extends Controller
{
    public function index()
    {
        $userguardemahasiswa = UserGuideMahasiswa::all();
        return view('pages.userguidepenggunamahasiswa.index', compact('userguardemahasiswa'));
    }
}
