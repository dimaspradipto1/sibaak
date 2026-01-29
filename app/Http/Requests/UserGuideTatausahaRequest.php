<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserGuideTatausahaRequest extends FormRequest
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
             'title' => 'required',
            'link_dokumen' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title wajib diisi',
            'link_dokumen.required' => 'Link dokumen wajib diisi',
        ];
    }
}
