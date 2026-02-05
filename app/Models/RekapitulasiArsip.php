<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekapitulasiArsip extends Model
{
    protected $guarded = [];

    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class);
    }

    public function skKepanitiaan()
    {
        return $this->belongsTo(SkKepanitiaan::class);
    }

    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class);
    }

    public function pedoman()
    {
        return $this->belongsTo(Pedoman::class);
    }

    public function sopAkademik()
    {
        return $this->belongsTo(SopAkademik::class);
    }

    public function wasdalbin()
    {
        return $this->belongsTo(Wasdalbin::class);
    }

    public function lpjKepanitiaan()
    {
        return $this->belongsTo(LpjKepanitiaan::class);
    }
}
