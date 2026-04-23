<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\UnitKerja;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Role::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Tambahkan Role Utama (Non-Unit)
        Role::create(['nama_role' => 'Super Admin', 'unit_kerja_id' => null]);
        Role::create(['nama_role' => 'Admin', 'unit_kerja_id' => null]);
        Role::create(['nama_role' => 'Administrator', 'unit_kerja_id' => null]);

        // 2. Ambil SEMUA Unit Kerja dan buatkan Role-nya masing-masing
        // Ini memastikan tidak ada satupun yang ketinggalan.
        $units = UnitKerja::all();

        foreach ($units as $unit) {
            Role::create([
                'nama_role' => $unit->nama_unit,
                'unit_kerja_id' => $unit->id
            ]);
        }

        // 3. Tambahan Role Khusus (jika ada yang bukan nama unit tapi jabatan umum)
        $extraRoles = [
            'Dosen',
            'Satuankerja',
            'Mahasiswa',
            'Sekretaris',
            'Bendahara'
        ];

        foreach ($extraRoles as $extra) {
            if (!Role::where('nama_role', $extra)->exists()) {
                Role::create(['nama_role' => $extra, 'unit_kerja_id' => null]);
            }
        }

        // 4. Berikan Izin Akses Penuh ke Admin
        $allPermissions = \App\Models\Permission::pluck('id')->toArray();
        $adminRoles = ['Super Admin', 'Admin', 'Administrator'];
        
        foreach ($adminRoles as $roleName) {
            $role = Role::where('nama_role', $roleName)->first();
            if ($role) {
                $role->permissions()->sync($allPermissions);
            }
        }

        // 5. Berikan Izin Arsip Utama ke SEMUA Role (Kecuali Mahasiswa)
        $arsipPermission = \App\Models\Permission::where('slug', 'arsip_utama_view')->first();
        if ($arsipPermission) {
            $nonMahasiswaRoles = Role::where('nama_role', '!=', 'Mahasiswa')
                                    ->whereNotIn('nama_role', $adminRoles)
                                    ->get();
            foreach ($nonMahasiswaRoles as $role) {
                // Gunakan attach/syncWithoutDetaching agar izin yang sudah ada tidak hilang
                $role->permissions()->syncWithoutDetaching([$arsipPermission->id]);
            }
        }

        // 6. Pastikan Akun Bapak (Admin Pertama) tetap bisa login dengan role tertinggi
        $admin = User::first();
        if ($admin) {
            $superRole = Role::where('nama_role', 'Super Admin')->first();
            if ($superRole) {
                $admin->update(['role_id' => $superRole->id]);
            }
        }
    }
}
