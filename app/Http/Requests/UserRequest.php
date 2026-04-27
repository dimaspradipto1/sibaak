<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->user ? (is_object($this->user) ? $this->user->id : $this->user) : 'NULL';

        return [
            'name' => 'required|string|max:255|unique:users,name,' . $userId,
            'email' => 'required|email|max:255|unique:users,email,' . $userId,
            'password' => $this->isMethod('POST') ? 'required' : 'nullable',
            'role_id' => 'required|exists:roles,id',
            'is_active' => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'Nama Lengkap wajib diisi',
            'name.unique'       => 'Nama sudah terdaftar',
            'email.required'    => 'Email wajib diisi',
            'email.unique'      => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'role_id.required'  => 'Role Akses wajib diisi',
        ];
    }
}
