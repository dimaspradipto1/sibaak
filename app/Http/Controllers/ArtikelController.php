<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\DataTables\ArtikelDataTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ArtikelController extends Controller
{
    public function index(ArtikelDataTable $dataTable)
    {
        \Illuminate\Support\Facades\Gate::authorize('artikel_view');
        $title = 'Portal Artikel & Informasi';
        return $dataTable->render('pages.artikel.index', compact('title'));
    }

    public function create()
    {
        \Illuminate\Support\Facades\Gate::authorize('artikel_create');
        $title = 'Tambah Artikel Baru';
        return view('pages.artikel.create', compact('title'));
    }

    public function store(Request $request)
    {
        \Illuminate\Support\Facades\Gate::authorize('artikel_create');
        $request->validate([
            'judul' => 'required|string|max:255',
            'tipe' => 'required',
            'konten' => 'required',
            'media_url' => 'nullable|url',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'keyword' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['users_id'] = Auth::id();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('assets/artikel', 'public');
        }

        Artikel::create($data);

        Alert::success('Berhasil', 'Artikel baru telah ditambahkan');
        return redirect()->route('artikel.index');
    }

    public function show($id)
    {
        \Illuminate\Support\Facades\Gate::authorize('artikel_view');
        $title = 'Detail Artikel';
        $artikel = Artikel::with('user')->findOrFail($id);
        
        // Convert YouTube URL to Embed if needed.
        $embed_url = null;
        if ($artikel->media_url) {
            if (preg_match('/(youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $artikel->media_url, $matches)) {
                $embed_url = 'https://www.youtube.com/embed/' . $matches[2];
            }
        }

        return view('pages.artikel.show', compact('title', 'artikel', 'embed_url'));
    }

    public function edit($id)
    {
        \Illuminate\Support\Facades\Gate::authorize('artikel_edit');
        $title = 'Edit Artikel';
        $artikel = Artikel::findOrFail($id);
        return view('pages.artikel.edit', compact('title', 'artikel'));
    }

    public function update(Request $request, $id)
    {
        \Illuminate\Support\Facades\Gate::authorize('artikel_edit');
        $artikel = Artikel::findOrFail($id);

        $request->validate([
            'judul' => 'required|string|max:255',
            'tipe' => 'required',
            'konten' => 'required',
            'media_url' => 'nullable|url',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'keyword' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            if ($artikel->gambar) {
                Storage::disk('public')->delete($artikel->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('assets/artikel', 'public');
        }

        $artikel->update($data);

        Alert::success('Berhasil', 'Artikel telah diperbarui');
        return redirect()->route('artikel.index');
    }

    public function destroy($id)
    {
        \Illuminate\Support\Facades\Gate::authorize('artikel_delete');
        $artikel = Artikel::findOrFail($id);
        
        if ($artikel->gambar) {
            Storage::disk('public')->delete($artikel->gambar);
        }
        
        $artikel->delete();

        Alert::success('Berhasil', 'Artikel telah dihapus');
        return redirect()->route('artikel.index');
    }
}
