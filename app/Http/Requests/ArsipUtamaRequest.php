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
            'kategori_arsip_id' => 'required_without:custom_kategori',
            'custom_kategori'   => 'nullable|string',
            'tahun_arsip'       => 'required|string|max:10',
            'nama_arsip'        => 'required|string|max:255',
            'file_arsip'        => ($this->isMethod('post') ? 'required' : 'nullable') . '|file|mimes:pdf|max:51200',
        ];
    }

    public function messages(): array
    {
        return [
            'kategori_arsip_id.required' => 'Kategori arsip wajib dipilih.',
            'kategori_arsip_id.exists'   => 'Kategori arsip tidak valid.',
            'custom_kategori.string'     => 'Kategori kustom harus berupa teks.',
            'tahun_arsip.required'       => 'Tahun arsip wajib diisi.',
            'tahun_arsip.string'         => 'Tahun arsip harus berupa teks.',
            'tahun_arsip.max'            => 'Tahun arsip maksimal 10 karakter.',
            'nama_arsip.required'        => 'Nama arsip wajib diisi.',
            'nama_arsip.string'          => 'Nama arsip harus berupa teks.',
            'nama_arsip.max'             => 'Nama arsip maksimal 255 karakter.',
            'file_arsip.required'        => 'File arsip wajib diunggah.',
            'file_arsip.mimes'           => 'File harus berformat PDF.',
            'file_arsip.max'             => 'Ukuran file maksimal 50MB.',
        ];
    }
}
