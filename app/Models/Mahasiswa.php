<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class);
    }

     public function suratAkademik()
    {
        return $this->hasMany(SuratAkademik::class);
    }
}
