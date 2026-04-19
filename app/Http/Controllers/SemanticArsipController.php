<?php

namespace App\Http\Controllers;

use App\Models\ArsipUtama;
use App\Models\Artikel;
use App\Models\Kurikulum;
use App\Models\LpjKepanitiaan;
use App\Models\Pedoman;
use App\Models\SkKepanitiaan;
use App\Models\SopAkademik;
use App\Models\Wasdalbin;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class SemanticArsipController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Semantic Search Arsip';
        $query = $request->input('q');
        $tab = $request->input('tab', 'semua');
        $results = collect();
        $top_result = null;

        if ($query) {
            // Helper to get Google Drive Thumbnail if available
            $getThumbnail = function($url) {
                if (preg_match('/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
                    return "https://drive.google.com/thumbnail?id=" . $matches[1] . "&sz=w600";
                }
                return null;
            };

            // Search in Artikel (Prioritized for Knowledge Panel)
            $artikelItems = Artikel::with(['user.role'])
                ->where(function($q) use ($query) {
                    $q->where('judul', 'like', "%$query%")
                      ->orWhere('tipe', 'like', "%$query%")
                      ->orWhere('konten', 'like', "%$query%")
                      ->orWhere('keyword', 'like', "%$query%");
                })
                ->get()
                ->map(function($item) {
                    $item->type = 'Artikel';
                    $item->title = $item->judul;
                    
                    // Improved Narrative Logic
                    $plain_text = trim(strip_tags($item->konten));
                    if (empty($plain_text)) {
                        $source = 'portal berita';
                        if ($item->is_youtube) $source = 'saluran YouTube';
                        if ($item->is_facebook) $source = 'halaman Facebook';
                        
                        $item->description = "Lihat informasi lengkap mengenai {$item->title} yang tersedia di {$source} resmi Universitas Ibnu Sina. Akses arsip digital untuk melihat detail publikasi ini.";
                    } else {
                        $item->description = Str::limit($plain_text, 170, '...');
                    }

                    $item->link = route('artikel.show', $item->id);
                    $item->icon = 'fa-newspaper';
                    $item->color = 'text-info';
                    $item->thumbnail = $item->gambar ? asset('storage/' . $item->gambar) : null;
                    
                    // Specific YouTube Handling
                    $item->is_youtube = false;
                    $item->is_facebook = false;
                    
                    if ($item->media_url && preg_match('/(youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $item->media_url, $matches)) {
                        $item->is_youtube = true;
                        $item->youtube_id = $matches[2];
                        $item->thumbnail = "https://img.youtube.com/vi/{$item->youtube_id}/mqdefault.jpg";
                        $item->link = $item->media_url;
                        $item->icon = 'fa-brands fa-youtube';
                        $item->color = 'text-danger';
                    } elseif ($item->media_url && str_contains($item->media_url, 'facebook.com')) {
                        $item->is_facebook = true;
                        $item->link = $item->media_url;
                        $item->icon = 'fa-brands fa-facebook';
                        $item->color = 'text-primary';
                    }

                    // Detect if media_url is a Map
                    $item->is_map = strpos($item->media_url, 'maps') !== false || strpos($item->media_url, 'goo.gl/maps') !== false;
                    $item->external_link = $item->media_url;
                    $item->kategori = $item->kategori; 
                    
                    return $item;
                });

            // Set top_result if search matches article title closely
            if ($artikelItems->count() > 0) {
                $top_result = $artikelItems->first();
            }

            // Search in Arsip Utama
            $arsipUtama = ArsipUtama::with(['user.role', 'kategoriArsip'])
                ->where(function($q) use ($query) {
                    $q->where('nama_arsip', 'like', "%$query%")
                      ->orWhereHas('kategoriArsip', function($sq) use ($query) {
                          $sq->where('kategori_arsip', 'like', "%$query%");
                      })
                      ->orWhereHas('user.role', function($sq) use ($query) {
                          $sq->where('nama_role', 'like', "%$query%");
                      });
                })
                ->get()
                ->map(function($item) use ($getThumbnail) {
                    $item->type = 'Arsip Utama';
                    $item->title = $item->nama_arsip;
                    $item->description = 'Dokumen ini merupakan arsip digital yang terdaftar dalam kategori ' . ($item->kategoriArsip->kategori_arsip ?? 'Umum') . '. Berkas ini disimpan untuk keperluan administrasi dan akreditasi internal UIS.';
                    $item->link = $item->file_arsip;
                    $item->icon = 'fa-file-pdf';
                    $item->color = 'text-danger';
                    $item->thumbnail = $getThumbnail($item->file_arsip);
                    return $item;
                });

            // Search in SK Kepanitiaan
            $sk = SkKepanitiaan::with(['users.role', 'jenissk'])
                ->where(function($q) use ($query) {
                    $q->where('nama_dokumen', 'like', "%$query%")
                      ->orWhere('nomor_sk', 'like', "%$query%")
                      ->orWhereHas('jenissk', function($sq) use ($query) {
                          $sq->where('jenis_sk', 'like', "%$query%");
                      })
                      ->orWhereHas('users.role', function($sq) use ($query) {
                          $sq->where('nama_role', 'like', "%$query%");
                      });
                })
                ->get()
                ->map(function($item) use ($getThumbnail) {
                    $item->type = 'SK Kepanitiaan';
                    $item->title = $item->nama_dokumen . ' (' . $item->nomor_sk . ')';
                    $item->description = 'Salinan resmi Dokumen SK Kepanitiaan dengan nomor registrasi ' . $item->nomor_sk . '. Dokumen ini telah diverifikasi dan tersimpan dalam pangkalan data arsip digital UIS.';
                    $item->link = $item->file;
                    $item->icon = 'fa-file-contract';
                    $item->color = 'text-primary';
                    $item->thumbnail = $getThumbnail($item->file);
                    return $item;
                });

            // Search in LPJ
            $lpj = LpjKepanitiaan::with(['users.role'])
                ->where(function($q) use ($query) {
                    $q->where('nama_dokumen', 'like', "%$query%")
                      ->orWhere('ketua', 'like', "%$query%")
                      ->orWhereHas('users.role', function($sq) use ($query) {
                          $sq->where('nama_role', 'like', "%$query%");
                      });
                })
                ->get()
                ->map(function($item) use ($getThumbnail) {
                    $item->type = 'LPJ Kepanitiaan';
                    $item->description = 'Laporan Pertanggungjawaban (LPJ) kegiatan. Ketua pelaksana: ' . $item->ketua . '.';
                    $item->title = $item->nama_dokumen;
                    $item->link = $item->file;
                    $item->icon = 'fa-file-invoice';
                    $item->color = 'text-success';
                    $item->thumbnail = $getThumbnail($item->file);
                    return $item;
                });

            // Search in Kurikulum
            $kurikulum = Kurikulum::with(['user.role'])
                ->where(function($q) use ($query) {
                    $q->where('nama_kurikulum', 'like', "%$query%")
                      ->orWhereHas('user.role', function($sq) use ($query) {
                          $sq->where('nama_role', 'like', "%$query%");
                      });
                })
                ->get()
                ->map(function($item) use ($getThumbnail) {
                    $item->type = 'Kurikulum';
                    $item->title = $item->nama_kurikulum;
                    $item->link = $item->file;
                    $item->icon = 'fa-book';
                    $item->color = 'text-info';
                    $item->thumbnail = $getThumbnail($item->file);
                    return $item;
                });

            // Search in Pedoman
            $pedoman = Pedoman::with(['users.role'])
                ->where(function($q) use ($query) {
                    $q->where('nama_pedoman', 'like', "%$query%")
                      ->orWhereHas('users.role', function($sq) use ($query) {
                          $sq->where('nama_role', 'like', "%$query%");
                      });
                })
                ->get()
                ->map(function($item) use ($getThumbnail) {
                    $item->type = 'Pedoman';
                    $item->title = $item->nama_pedoman;
                    $item->link = $item->file;
                    $item->icon = 'fa-book-open';
                    $item->color = 'text-warning';
                    $item->thumbnail = $getThumbnail($item->file);
                    return $item;
                });

            // Search in SOP
            $sop = SopAkademik::with(['users.role'])
                ->where(function($q) use ($query) {
                    $q->where('nama_sop', 'like', "%$query%")
                      ->orWhereHas('users.role', function($sq) use ($query) {
                          $sq->where('nama_role', 'like', "%$query%");
                      });
                })
                ->get()
                ->map(function($item) use ($getThumbnail) {
                    $item->type = 'SOP Akademik';
                    $item->title = $item->nama_sop;
                    $item->link = $item->file;
                    $item->icon = 'fa-file-code';
                    $item->color = 'text-secondary';
                    $item->thumbnail = $getThumbnail($item->file);
                    return $item;
                });

            // Search in Wasdalbin
            $wasdalbin = Wasdalbin::with(['users.role'])
                ->where(function($q) use ($query) {
                    $q->where('nama_wasdalbin', 'like', "%$query%")
                      ->orWhereHas('users.role', function($sq) use ($query) {
                          $sq->where('nama_role', 'like', "%$query%");
                      });
                })
                ->get()
                ->map(function($item) use ($getThumbnail) {
                    $item->type = 'Wasdalbin';
                    $item->title = $item->nama_wasdalbin;
                    $item->link = $item->file;
                    $item->icon = 'fa-shield-halved';
                    $item->color = 'text-dark';
                    $item->thumbnail = $getThumbnail($item->file);
                    return $item;
                });

            $results = $results->concat($artikelItems)
                               ->concat($arsipUtama)
                               ->concat($sk)
                               ->concat($lpj)
                               ->concat($kurikulum)
                               ->concat($pedoman)
                               ->concat($sop)
                               ->concat($wasdalbin);

            // Filter logic based on tab
            if ($tab == 'terbaru') {
                $results = $results->sortByDesc('created_at');
            } elseif ($tab == 'gambar') {
                $results = $results->whereNotNull('thumbnail')->where('thumbnail', '!=', '');
            } elseif ($tab == 'video') {
                $results = $results->filter(function($item) {
                    return (isset($item->is_youtube) && $item->is_youtube) || (isset($item->is_facebook) && $item->is_facebook);
                });
            } elseif ($tab == 'berita') {
                $results = $results->filter(function($item) {
                    return $item->type == 'Artikel' && in_array($item->kategori, ['Berita', 'Informasi', 'Pengumuman', 'Tutorial']);
                });
            }

            // PAGINATION LOGIC
            $perPage = 10;
            $currentPage = request()->input('page', 1);
            $currentItems = $results->slice(($currentPage - 1) * $perPage, $perPage)->all();

            $results = new LengthAwarePaginator(
                $currentItems,
                $results->count(),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'query' => request()->query()]
            );
        }

        return view('pages.semantic.index', compact('title', 'results', 'query', 'tab', 'top_result'));
    }
}
