<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkKepanitiaan extends Model
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
        return $this->belongsTo(JenisSK::class, 'jenissk_id', 'id');
    }

    public function rekapitulasiArsip()
    {
        return $this->hasOne(RekapitulasiArsip::class);
    }

    protected static function booted()
    {
        static::created(function ($skKepanitiaan) {
            RekapitulasiArsip::create([
                'tahun_akademik_id' => $skKepanitiaan->tahun_akademik_id,
                'semester' => $skKepanitiaan->semester,
                'jenis_arsip' => 'SkKepanitiaan',
                'fakultas' => $skKepanitiaan->fakultas,
                'sk_kepanitiaan_id' => $skKepanitiaan->id,
            ]);
        });
    }
}
