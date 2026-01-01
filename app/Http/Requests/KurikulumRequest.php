<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KurikulumRequest extends FormRequest
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
            'tahun' => 'required',
            'nama_kurikulum' => 'required',
            'prodi' => 'required',
            'file' => ($this->isMethod('post') ? 'required' : 'nullable') . '|file|mimes:pdf|max:51200',
        ];
    }

    public function messages()
    {
        return [
            'tahun.required' => 'Tahun Wajib Diisi',
            'nama_kurikulum.required' => 'Nama Kurikulum Wajib Diisi',
            'prodi.required' => 'Prodi Wajib Diisi',
            'file.required' => 'File Wajib Diisi',
            'file.mimes' => 'File Harus PDF',
            'file.max' => 'File Maksimal 50MB',
        ];
    }
}
