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
            'unit_kerja_id' => 'nullable|exists:unit_kerjas,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_role.required' => 'Nama role wajib diisi',
        ];
    }
}
