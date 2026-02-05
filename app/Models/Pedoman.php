<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedoman extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function rekapitulasiArsip()
    {
        return $this->hasOne(RekapitulasiArsip::class);
    }

    protected static function booted()
    {
        static::created(function ($pedoman) {
            RekapitulasiArsip::create([
                'tahun_akademik_id' => $pedoman->tahun_akademik_id ?? null,
                'semester' => $pedoman->semester ?? null,
                'tahun' => $pedoman->tahun ?? null,
                'jenis_arsip' => 'Pedoman',
                'fakultas' => $pedoman->fakultas,
                'pedoman_id' => $pedoman->id,
            ]);
        });
    }
}
