<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function rekapitulasiArsip()
    {
        return $this->hasOne(RekapitulasiArsip::class);
    }

    protected static function booted()
    {
        static::created(function ($kurikulum) {
            RekapitulasiArsip::create([
                'tahun_akademik_id' => $kurikulum->tahun_akademik_id ?? null,
                'semester' => $kurikulum->semester ?? null,
                'tahun' => $kurikulum->tahun ?? null,
                'jenis_arsip' => 'Kurikulum',
                'fakultas' => $kurikulum->fakultas,
                'kurikulum_id' => $kurikulum->id,
            ]);
        });
    }
}
