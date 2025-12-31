<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TahunAkademik extends Model
{
    protected $guarded = [];

    public function skkepanitiaan()
    {
        return $this->hasMany(SkKepanitiaan::class);
    }
}
