<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DosenRequest extends FormRequest
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
        return [
            'nama_dosen' => 'required|string|max:255',
            'email' => 'required|email',
            'nidn' => 'nullable|numeric',
            'nuptk' => 'nullable|numeric',
            'nup' => 'nullable|numeric',
            'program_studi_id' => 'required|exists:program_studis,id',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_dosen.required' => 'Nama dosen wajib diisi.',
            'nama_dosen.max' => 'Nama dosen maksimal 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Email tidak valid.',
            'nidn.numeric' => 'NIDN harus berupa angka.',
            'nuptk.numeric' => 'NUPTK harus berupa angka.',
            'nup.numeric' => 'NUP harus berupa angka.',
            'program_studi_id.required' => 'Program studi wajib diisi.',
            'program_studi_id.exists' => 'Program studi tidak valid.',
        ];
    }
}
