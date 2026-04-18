<?php

namespace App\Http\Controllers;

use App\Models\ArsipUtama;
use App\Models\SkKepanitiaan;
use App\Models\LpjKepanitiaan;
use App\Models\Kurikulum;
use App\Models\Pedoman;
use App\Models\SopAkademik;
use App\Models\Wasdalbin;
use Illuminate\Http\Request;

class SemanticArsipController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Semantic Search Arsip';
        $query = $request->input('q');
        $tab = $request->input('tab', 'semua');
        $results = collect();

        if ($query) {
            // Helper to get Google Drive Thumbnail if available
            $getThumbnail = function($url) {
                if (preg_match('/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {
                    return "https://drive.google.com/thumbnail?id=" . $matches[1] . "&sz=w600";
                }
                return null;
            };

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

            $results = $results->concat($arsipUtama)
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
                $results = $results->whereNotNull('link')->where('link', '!=', '');
            }
        }

        return view('pages.semantic.index', compact('title', 'results', 'query', 'tab'));
    }
}
