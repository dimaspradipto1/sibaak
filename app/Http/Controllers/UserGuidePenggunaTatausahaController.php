<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserGuideTatausaha;

class UserGuidePenggunaTatausahaController extends Controller
{
    public function index()
    {
        $userguidepenggunatatausaha = UserGuideTatausaha::all();
        return view('pages.userguidepenggunatatausaha.index', compact('userguidepenggunatatausaha'));
    }
}
