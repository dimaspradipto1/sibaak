<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Str;

class UsersImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Find role by name
        $role = Role::where('nama_role', 'like', '%' . $row['role'] . '%')->first();
        
        // Default to Staff or lower if not found, or skip? 
        // Let's assume the user provides correct role names from the template.
        if (!$role) {
            return null; // Skip if role not found
        }

        return new User([
            'name'      => $row['nama'],
            'email'     => $row['email'],
            'password'  => Hash::make($row['password']),
            'role_id'   => $role->id,
            'is_active' => 1,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|string',
        ];
    }
}
