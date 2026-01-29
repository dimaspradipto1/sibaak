<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGuidePenggunaMahasiswa extends Model
{
    protected $guarded = [];

    public function userguardemahasiswa()
    {
        return $this->belongsTo(UserGuideMahasiswa::class);
    }
}
