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
            // 'users_id' => 'required|exists:users,id',
            'nama_staff'    => 'required',
            'jabatan'       => 'required',
            'nidn'          => 'nullable',
            'nup'           =>'required',
            'homebase'      => 'required',
            'file'          => 'nullable|image|mimes:jpg,png|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'nama_staff.required'   => 'nama Pengguna wajib diisi',
            'users_id.exists'       => 'nama Pengguna tidak ditemukan',
            'jabatan.required'      => 'Jabatan wajib diisi',
            'nup.required'          => 'NUP wajib diisi',
            'file.mimes'            => 'File harus berformat JPEG, PNG, JPG, GIF, atau SVG',
            'file.max'              => 'Ukuran file tidak boleh melebihi 2MB',   
        ];
    }
}
