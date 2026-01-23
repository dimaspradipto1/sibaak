<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    protected $guarded = [];

    public function mahasiswa()
    {
        return $this->hasMany(Mahasiswa::class);
    }

    public function suratAktif()
    {
        return $this->hasMany(SuratAktif::class);
    }

    public function suratAkademik()
    {
        return $this->hasMany(SuratAkademik::class);
    }

    public function dosen()
    {
        return $this->hasMany(Dosen::class);
    }
}
