<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGuideTatausaha extends Model
{
    protected $guarded = [];

    public function userguidepenggunatatausaha()
    {
        return $this->hasMany(UserGuidePenggunaTatausaha::class);
    }
}
