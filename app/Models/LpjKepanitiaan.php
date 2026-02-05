<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LpjKepanitiaan extends Model
{
    protected $guarded = [];

    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
    
    public function jenissk()
    {
        return $this->belongsTo(JenisSk::class);
    }

    public function rekapitulasiArsip()
    {
        return $this->hasOne(RekapitulasiArsip::class);
    }

    protected static function booted()
    {
        static::created(function ($lpjKepanitiaan) {
            RekapitulasiArsip::create([
                'tahun_akademik_id' => $lpjKepanitiaan->tahun_akademik_id,
                'semester' => $lpjKepanitiaan->semester,
                'jenis_arsip' => 'LpjKepanitiaan',
                'fakultas' => $lpjKepanitiaan->fakultas,
                'lpj_kepanitiaan_id' => $lpjKepanitiaan->id,
            ]);
        });
    }
}
