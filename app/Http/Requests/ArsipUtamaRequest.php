<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArsipUtamaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'kategori_arsip_id' => 'required|exists:kategori_arsips,id',
            'tahun_arsip'       => 'required|string|max:10',
            'nama_arsip'        => 'required|string|max:255',
            'file_arsip'        => ($this->isMethod('post') ? 'required' : 'nullable') . '|file|mimes:pdf|max:51200',
        ];
    }

    public function messages(): array
    {
        return [
            'kategori_arsip_id.required' => 'Kategori arsip wajib dipilih',
            'kategori_arsip_id.exists'   => 'Kategori arsip tidak valid',
            'tahun_arsip.required'       => 'Tahun arsip wajib diisi',
            'nama_arsip.required'        => 'Nama arsip wajib diisi',
            'file_arsip.required'        => 'File arsip wajib diunggah',
            'file_arsip.mimes'           => 'File harus berformat PDF',
            'file_arsip.max'             => 'Ukuran file maksimal 50MB',
        ];
    }
}
