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

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'is_active',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole($role)
    {
        return $this->role && strtoupper(trim($this->role->nama_role)) === strtoupper(trim($role));
    }

    public function getIsSuperadminAttribute()
    {
        return $this->hasRole('SUPER ADMIN') || $this->hasRole('SUPERADMIN');
    }

    public function getIsAdminAttribute()
    {
        return $this->hasRole('ADMIN') || $this->hasRole('ADMINISTRATOR');
    }

    public function getIsMahasiswaAttribute()
    {
        return $this->hasRole('MAHASISWA');
    }

    public function getIsTataUsahaAttribute()
    {
        return str_contains($this->role?->nama_role ?? '', 'TATA USAHA');
    }

    public function getIsStaffbaakAttribute()
    {
        return str_contains($this->role?->nama_role ?? '', 'BAAK');
    }

    public function getIsApprovalAttribute()
    {
        return $this->hasRole('APPROVAL');
    }

    public function getIsOperatorAttribute()
    {
        return str_contains($this->role?->nama_role ?? '', 'OPERATOR');
    }

    public function getCanSeeStaffNameAttribute()
    {
        if ($this->is_superadmin || $this->is_admin) {
            return true;
        }

        $roleName = strtoupper($this->role?->nama_role ?? '');
        return str_contains($roleName, 'KABID.') || str_contains($roleName, 'KA. BIRO');
    }

    public function getFakultasAttribute()
    {
        $roleName = strtoupper($this->role?->nama_role ?? '');

        if (str_contains($roleName, 'EKONOMI DAN BISNIS')) {
            return 'Fakultas Ekonomi dan Bisnis';
        }
        if (str_contains($roleName, 'SAINS DAN TEKNOLOGI')) {
            return 'Fakultas Sains dan Teknologi';
        }
        if (str_contains($roleName, 'ILMU KESEHATAN')) {
            return 'Fakultas Ilmu Kesehatan';
        }
        if (str_contains($roleName, 'TEKNIK')) {
            return 'Fakultas Teknik';
        }
        if (str_contains($roleName, 'PASCASARJANA')) {
            return 'Pascasarjana';
        }

        return null;
    }

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
