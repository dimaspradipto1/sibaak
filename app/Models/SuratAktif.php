<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratAktif extends Model
{
    protected $guarded = [];

    public function getRouteKey()
    {
        $id = $this->getAttribute($this->getKeyName());
        // Stable scrambling logic
        $val = ($id * 1234567) ^ 0x12345678;

        $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $hash = "";
        while ($val > 0) {
            $hash .= $chars[$val % 62];
            $val = (int)($val / 62);
        }
        return $hash;
    }

    public static function decodeHash($hash)
    {
        $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $val = 0;
        $mul = 1;

        try {
            for ($i = 0; $i < strlen($hash); $i++) {
                $pos = strpos($chars, $hash[$i]);
                if ($pos === false) return null;
                $val += $pos * $mul;
                $mul *= 62;
            }
            // Fixed precedence: XOR must be wrapped in parentheses
            $id = ($val ^ 0x12345678) / 1234567;
            return (is_numeric($id) && floor($id) == $id && $id > 0) ? (int)$id : null;
        } catch (\Exception $e) {
            return null;
        }
    }

    public function resolveRouteBinding($value, $field = null)
    {
        $id = self::decodeHash($value);
        return $this->where($field ?? $this->getKeyName(), $id)->first();
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'program_studi_id');
    }

    public function tahunAkademik()
    {
        return $this->belongsTo(TahunAkademik::class, 'tahun_akademik_id');
    }

    public function rekapitulasiSuratAktif()
    {
        return $this->hasMany(RekapitulasiSuratAktif::class);
    }
}
