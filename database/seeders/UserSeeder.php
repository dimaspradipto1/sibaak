<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'is_admin' => true,
                'is_staffbaak' => false,
                'is_mahasiswa' => false,
                'is_tata_usaha' => false,
                'is_approval' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Leni Utami, S.Si.,M.KM',
                'email' => 'leni@uis.ac.id',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_staffbaak' => false,
                'is_mahasiswa' => false,
                'is_tata_usaha' => false,
                'is_approval' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Andi Hidayatul Fadlilah, SE,M. Si.AK',
                'email' => 'andihidayatul@uis.ac.id',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_staffbaak' => false,
                'is_mahasiswa' => false,
                'is_tata_usaha' => false,
                'is_approval' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Staff BAAK',
                'email' => 'baak@uis.ac.id',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_staffbaak' => true,
                'is_mahasiswa' => false,
                'is_tata_usaha' => false,
                'is_approval' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mahasiswa',
                'email' => 'mahasiswa@uis.ac.id',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_staffbaak' => false,
                'is_mahasiswa' => true,
                'is_tata_usaha' => false,
                'is_approval' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mahasiswa 2',
                'email' => 'mahasiswa2@uis.ac.id',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_staffbaak' => false,
                'is_mahasiswa' => true,
                'is_tata_usaha' => false,
                'is_approval' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tata Usaha rektorat',
                'email' => 'tatausaha@uis.ac.id',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_staffbaak' => false,
                'is_mahasiswa' => false,
                'is_tata_usaha' => true,
                'is_approval' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TU FST',
                'email' => 'fst@uis.ac.id',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_staffbaak' => false,
                'is_mahasiswa' => false,
                'is_tata_usaha' => true,
                'is_approval' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TU FEB',
                'email' => 'feb@uis.ac.id',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_staffbaak' => false,
                'is_mahasiswa' => false,
                'is_tata_usaha' => true,
                'is_approval' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'TU FIKES',
                'email' => 'fikes@uis.ac.id',
                'password' => Hash::make('password'),
                'is_admin' => false,
                'is_staffbaak' => false,
                'is_mahasiswa' => false,
                'is_tata_usaha' => true,
                'is_approval' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];
       
        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }
    }
}
