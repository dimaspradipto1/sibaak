<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PegawaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'users_id' => 'required|exists:users,id',
            'jabatan' => 'required',
            'nidn' => 'required',
            'file' => 'nullable|image|mimes:jpg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'users_id.required' => 'nama Pengguna wajib diisi',
            'users_id.exists' => 'nama Pengguna tidak ditemukan',
            'jabatan.required' => 'Jabatan wajib diisi',
            'nidn.required' => 'NIDN wajib diisi',
            'file.mimes' => 'File harus berformat JPEG, PNG, JPG, GIF, atau SVG',
            'file.max' => 'Ukuran file tidak boleh melebihi 2MB',   
        ];
    }
}
