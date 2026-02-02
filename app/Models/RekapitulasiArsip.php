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
}
