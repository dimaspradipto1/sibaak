<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LpjKepanitiaanRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tahun_akademik_id' => 'required',
            'semester' => 'required',
            'nama_dokumen' => 'required',
            'ketua' => 'required',
            'sekretaris' => 'required',
            'prodi' => 'required',
            'file' => ($this->isMethod('post') ? 'required' : 'nullable') . '|file|mimes:pdf|max:51200',
        ];
    }

    public function messages()
    {
        return [
            'tahun_akademik_id.required' => 'Tahun Akademik Wajib Diisi',
            'semester.required' => 'Semester Wajib Diisi',
            'nama_dokumen.required' => 'Nama Dokumen Wajib Diisi',
            'ketua.required' => 'Ketua Wajib Diisi',
            'sekretaris.required' => 'Sekretaris Wajib Diisi',
            'prodi.required' => 'Program Studi Wajib Diisi',
            'file.required' => 'File Wajib Diisi',
            'file.mimes' => 'File Harus PDF',
            'file.max' => 'File Maksimal 50MB',
        ];
    }
}
