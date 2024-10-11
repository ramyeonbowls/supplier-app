<?php

namespace App\Http\Requests\Upload;

use Illuminate\Foundation\Http\FormRequest;

class EncryptBooksRequest extends FormRequest
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
            'file_cover' => 'required|mimes:zip',
            'file_pdf' => 'required|mimes:zip',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'file_cover' => 'File Cover Zip',
            'file_pdf' => 'File Pdf Zip',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'file_cover.required' => ':attribute diperlukan.',
            'file_cover.mimes' => ':attribute file bukan zip.',
            'file_pdf.required' => ':attribute diperlukan.',
            'file_pdf.mimes' => ':attribute file bukan zip.',
        ];
    }
}
