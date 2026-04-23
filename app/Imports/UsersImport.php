<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Str;

class UsersImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, SkipsOnFailure
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Find role by name
        $roleName = $row['role'] ?? null;
        if (!$roleName) return null;

        $role = Role::where('nama_role', 'like', '%' . trim($roleName) . '%')->first();
        
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

    public function onFailure(Failure ...$failures)
    {
        // Failures are handled by the library, but we can log them if needed
    }
}
