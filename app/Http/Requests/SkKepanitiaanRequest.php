<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkKepanitiaanRequest extends FormRequest
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
            'tahun_akademik_id' => 'required',
            'semester' => 'required',
            'nama_sk' => 'required',
            'nomor_sk' => 'required',
            'jenissk_id' => 'required',
            'prodi' => 'required',
            'file' => ($this->isMethod('post') ? 'required' : 'nullable') . '|file|mimes:pdf|max:51200',
        ];
    }

    public function messages()
    {
        return [
            'tahun_akademik_id.required' => 'Tahun Akademik wajib diisi',
            'semester.required' => 'Semester wajib diisi',
            'nama_sk.required' => 'Nama SK wajib diisi',
            'nomor_sk.required' => 'Nomor SK wajib diisi',
            'jenissk_id.required' => 'Jenis SK wajib diisi',
            'prodi.required' => 'Program Studi wajib diisi',
            'file.required' => 'File wajib diisi',
            'file.file' => 'File harus berupa file',
            'file.mimes' => 'File harus berupa PDF',
            'file.max' => 'File maksimal 50MB',
        ];
    }
}
