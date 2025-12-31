<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LpjKepanitiaan extends Model
{
    protected $guarded = [];

    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
