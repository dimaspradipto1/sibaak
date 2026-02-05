<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wasdalbin extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function rekapitulasiArsip()
    {
        return $this->hasOne(RekapitulasiArsip::class);
    }

    protected static function booted()
    {
        static::created(function ($wasdalbin) {
            RekapitulasiArsip::create([
                'tahun_akademik_id' => $wasdalbin->tahun_akademik_id ?? null,
                'semester' => $wasdalbin->semester ?? null,
                'tahun' => $wasdalbin->tahun ?? null,
                'jenis_arsip' => 'Wasdalbin',
                'fakultas' => $wasdalbin->fakultas,
                'wasdalbin_id' => $wasdalbin->id,
            ]);
        });
    }
    
}
