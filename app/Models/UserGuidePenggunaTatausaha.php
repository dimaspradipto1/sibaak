<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGuidePenggunaTatausaha extends Model
{
    protected $guarded = [];


    public function userguidetatausaha()
    {
        return $this->belongsTo(UserGuideTatausaha::class);
    }
}
