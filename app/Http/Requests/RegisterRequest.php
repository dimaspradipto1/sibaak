<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => 'required|string|max:255',
            'email'    => [
                'required',
                'email',
                'unique:users,email',
                'regex:/@uis\.ac\.id$/',
            ],
            'password' => 'required|string|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Nama lengkap tidak boleh kosong.',
            'name.max'          => 'Nama lengkap maksimal 255 karakter.',
            'email.required'    => 'Email tidak boleh kosong.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email ini sudah terdaftar, silakan gunakan email lain.',
            'email.regex'       => 'Hanya email dengan domain @uis.ac.id yang diizinkan mendaftar.',
            'password.required' => 'Password tidak boleh kosong.',
            'password.min'      => 'Password minimal harus 8 karakter.',
        ];
    }
}
