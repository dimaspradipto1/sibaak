<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    public function suratAkademik()
    {
        return $this->hasMany(SuratAkademik::class, 'dosen_id');
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }
}
