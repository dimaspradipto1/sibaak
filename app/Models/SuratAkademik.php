<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratAkademik extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'users_id');
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }
}
