<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGuide extends Model
{
    protected $guarded = [];

    public function faq()
    {
        return $this->hasMany(FAQ::class, 'userguide_id', 'id');
    }
}
