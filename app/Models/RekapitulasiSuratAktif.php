<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapitulasiSuratAktif extends Model
{
    protected $guarded = [];

    public function suratAktif()
    {
        return $this->belongsTo(SuratAktif::class);
    }

    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class);
    }
}
