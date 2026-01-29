<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use Illuminate\Http\Request;
use App\DataTables\FAQDataTable;
use App\Http\Requests\FAQRequest;
use RealRashid\SweetAlert\Facades\Alert;

class FAQController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(FAQDataTable $datatable)
    {
        $title = 'FAQ';
        return $datatable->render('pages.faq.index', compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'FAQ';
        return view('pages.faq.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FAQRequest $request)
    {
        FAQ::create($request->all());
        Alert::success('Success', 'FAQ berhasil ditambahkan')
            ->toToast()
            ->autoClose(4000)
            ->timerProgressBar();
        return redirect()->route('faq.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(FAQ $fAQ)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FAQ $faq)
    {
        $title = 'FAQ';
        return view('pages.faq.edit', compact('title', 'faq'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FAQ $faq)
    {
        $faq->update($request->all());
        Alert::success('Success', 'FAQ berhasil diupdate')
            ->toToast()
            ->autoClose(4000)
            ->timerProgressBar();
        return redirect()->route('faq.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FAQ $faq)
    {
        $faq->delete();
        Alert::success('Success', 'FAQ berhasil dihapus')
            ->toToast()
            ->autoClose(4000)
            ->timerProgressBar();
        return redirect()->route('faq.index');
    }

    public function userguidepengguna()
    {
        $title = 'User Guide';
        $faqs = FAQ::all();

        return view('pages.userguidepengguna.index', compact('title', 'faqs'));
    }
}
