<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    protected $guarded = [];

    public function userguide()
    {
        return $this->belongsTo(UserGuide::class, 'userguide_id', 'id');
    }
}
