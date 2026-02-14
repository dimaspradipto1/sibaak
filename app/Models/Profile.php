<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function mahasiswa()
    {
        return $this->hasOneThrough(Mahasiswa::class, User::class, 'id', 'users_id', 'users_id', 'id');
    }

    public function pegawai()
    {
        return $this->hasOneThrough(Pegawai::class, User::class, 'id', 'users_id', 'users_id', 'id');
    }

    public function dosen()
    {
        return $this->hasOneThrough(Dosen::class, User::class, 'id', 'email', 'users_id', 'email');
    }
}
