<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'nama_role' => 'required|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_role.required' => 'Nama role wajib diisi',
        ];
    }
}
