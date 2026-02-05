<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SopAkademik extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function rekapitulasiArsip()
    {
        return $this->hasOne(RekapitulasiArsip::class);
    }

    protected static function booted()
    {
        static::created(function ($sopakademik) {
            RekapitulasiArsip::create([
                'tahun_akademik_id' => $sopakademik->tahun_akademik_id ?? null,
                'semester' => $sopakademik->semester ?? null,
                'tahun' => $sopakademik->tahun ?? null,
                'jenis_arsip' => 'SOP Akademik',
                'fakultas' => $sopakademik->fakultas,
                'sop_akademik_id' => $sopakademik->id,
            ]);
        });
    }
}
