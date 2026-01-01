<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedoman extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
