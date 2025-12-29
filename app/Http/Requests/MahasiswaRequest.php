<?php

namespace App\Http\Requests;

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
        return [
            'users_id' => 'required|exists:users,id',
            'program_studi_id' => 'required|exists:program_studis,id',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required|date',
            'npm' => 'required|numeric',
            'jenjang_pendidikan' => 'required|string',
            'fakultas' => 'required|string',
            'semester' => 'required|string',
            'alamat' => 'required|string',
            'no_wa' => 'required|numeric',
        ];
    }
}
