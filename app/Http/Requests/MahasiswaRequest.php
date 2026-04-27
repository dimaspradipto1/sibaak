<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class MahasiswaRequest extends FormRequest
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
        $mahasiswaId = $this->route('mahasiswa') ? $this->route('mahasiswa')->id : null;

        $rules = [
            'program_studi_id' => 'required|exists:program_studis,id',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required|date',
            'npm' => 'required|numeric|unique:mahasiswas,npm,' . $mahasiswaId,
            'jenjang_pendidikan' => 'required|string',
            'fakultas' => 'required|string',
            'semester' => 'required|string',
            'alamat' => 'required|string',
            'no_wa' => 'required|numeric',
        ];

        // Jika user yang login adalah mahasiswa, kita tidak perlu memasukkan `users_id`
        if (!Auth::user()->is_mahasiswa) {
            $rules['users_id'] = 'required|exists:users,id|unique:mahasiswas,users_id,' . $mahasiswaId;
        } else {
            // Jika mahasiswa mengedit datanya sendiri, pastikan users_id tetap unik kecuali miliknya sendiri
            $rules['users_id'] = 'nullable|unique:mahasiswas,users_id,' . $mahasiswaId;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'users_id.required' => 'Pilih user terlebih dahulu.',
            'users_id.unique' => 'User ini sudah memiliki profil mahasiswa.',
            'program_studi_id.required' => 'Pilih program studi terlebih dahulu.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tgl_lahir.required' => 'Tanggal lahir wajib diisi.',
            'npm.required' => 'NPM wajib diisi.',
            'npm.unique' => 'NPM ini sudah terdaftar.',
            'jenjang_pendidikan.required' => 'Jenjang pendidikan wajib diisi.',
            'fakultas.required' => 'Fakultas wajib diisi.',
            'semester.required' => 'Semester wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'no_wa.required' => 'Nomor WhatsApp wajib diisi.',
        ];
    }
}
