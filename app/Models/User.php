<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'is_staffbaak',
        'is_tata_usaha',
        'is_mahasiswa',
        'is_approval',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'users_id');
    }

    public function pegawai()
    {
        return $this->hasOne(Pegawai::class, 'users_id');
    }

    public function dosen()
    {
        return $this->hasOne(Dosen::class, 'email', 'email');
    }

    public function skkepanitiaan()
    {
        return $this->hasMany(SkKepanitiaan::class);
    }

    public function kurikulum()
    {
        return $this->hasMany(Kurikulum::class);
    }

    public function pedoman()
    {
        return $this->hasMany(Pedoman::class);
    }

    public function sopakademik()
    {
        return $this->hasMany(SopAkademik::class);
    }

    public function wasdalbin()
    {
        return $this->hasMany(Wasdalbin::class);
    }

    public function suratAktif()
    {
        return $this->hasMany(SuratAktif::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class, 'users_id');
    }
}
