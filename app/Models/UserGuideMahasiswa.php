<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGuideMahasiswa extends Model
{
    protected $guarded = [];

    public function userguidepenggunamahasiswa()
    {
        return $this->hasMany(UserGuidePenggunaMahasiswa::class);
    }
}
