<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SopAkademik extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }
}
