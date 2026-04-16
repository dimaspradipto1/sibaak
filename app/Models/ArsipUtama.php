<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArsipUtama extends Model
{
    protected $guarded = [];

    public function kategoriArsip()
    {
        return $this->belongsTo(KategoriArsip::class, 'kategori_arsip_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
