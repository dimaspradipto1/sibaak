<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'    => 'required|email',
            'password' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'email.required'    => 'Email tidak boleh kosong.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Password tidak boleh kosong.',
        ];
    }

    /**
     * Setelah validasi berhasil, coba autentikasi.
     * - Email tidak ditemukan → error di field email
     * - Email ada tapi password salah → error di field password
     */
    public function authenticate(): void
    {
        $emailExists = \App\Models\User::where('email', $this->email)->exists();

        if (!$emailExists) {
            throw ValidationException::withMessages([
                'email' => 'Email tidak terdaftar dalam sistem.',
            ]);
        }

        if (!Auth::attempt($this->only('email', 'password'))) {
            throw ValidationException::withMessages([
                'password' => 'Password yang Anda masukkan salah.',
            ]);
        }
    }
}
