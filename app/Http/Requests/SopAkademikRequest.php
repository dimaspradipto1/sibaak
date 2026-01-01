<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SopAkademikRequest extends FormRequest
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
            'nama_sop' => 'required',
            'file' => ($this->isMethod('post') ? 'required' : 'nullable') . '|file|mimes:pdf|max:51200',
        ];
    }

    public function messages()
    {
        return [
            'nama_sop.required' => 'Nama SOP Wajib Diisi',
            'file.required' => 'File Wajib Diisi',
            'file.mimes' => 'File Harus PDF',
            'file.max' => 'File Maksimal 50MB',
        ];
    }
}
