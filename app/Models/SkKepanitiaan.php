<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SkKepanitiaan extends Model
{
    protected $fillable = [
        'tahun_akademik_id',
        'users_id',
        'jenissk_id',
        'nama_sk',
        'semester',
        'nomor_sk',
        'prodi',
        'file',
    ];

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
}
