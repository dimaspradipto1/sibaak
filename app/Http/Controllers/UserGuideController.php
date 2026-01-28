<?php

namespace App\Http\Controllers;

use App\Models\UserGuide;
use App\Models\FAQ;
use Illuminate\Http\Request;

class UserGuideController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'User Guide';
        $userguides = UserGuide::all();
        $faqs = FAQ::all();
        return view('pages.userguide.index', compact('userguides', 'faqs', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserGuide $userGuide)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserGuide $userGuide)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserGuide $userGuide)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserGuide $userGuide)
    {
        //
    }
}
