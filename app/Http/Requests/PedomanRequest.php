<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedomanRequest extends FormRequest
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
            'nama_pedoman' => 'required',
            'file' => ($this->isMethod('post') ? 'required' : 'nullable') . '|file|mimes:pdf|max:51200',
        ];
    }

    public function messages(): array
    {
        return [
            'tahun.required' => 'Tahun harus diisi',
            'nama_pedoman.required' => 'Nama Pedoman harus diisi',
            'file.required' => 'File harus diisi',
            'file.mimes' => 'File harus berformat PDF',
            'file.max' => 'File tidak boleh lebih dari 50MB',
        ];
    }
}
