<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wasdalbin extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class);
    }
    
}
