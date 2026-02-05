<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WasdalbinRequest extends FormRequest
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
            'nama_wasdalbin' => 'required',
            'fakultas' => 'required',
            'file' => ($this->isMethod('post') ? 'required' : 'nullable') . '|file|mimes:pdf|max:51200',
        ];
    }

    public function messages()
    {
        return [
            'tahun.required' => 'Tahun wajib diisi',
            'nama_wasdalbin.required' => 'Nama Wasdalbin wajib diisi',
            'fakultas.required' => 'Fakultas wajib diisi',
            'file.required' => 'File wajib diisi',
            'file.file' => 'File harus berupa file',
            'file.mimes' => 'File harus berupa PDF',
            'file.max' => 'File maksimal 50MB',
        ];
    }
}
