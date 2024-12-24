<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class UploadPaidOffRequest extends FormRequest
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
            'client_id' => 'nullable',
            'client_name' => 'nullable',
            'supplier_id' => 'nullable',
            'supplier_name' => 'nullable',
            'po_number' => 'nullable',
            'po_date' => 'nullable',
            'po_type' => 'nullable',
            'po_amount' => 'nullable',
            'po_discount' => 'nullable',
            'persentase_supplier' => 'nullable',
            'status' => 'nullable',
            'po_nett' => 'nullable',
            'file_images' => 'required|mimes:jpg,jpeg,png|max:1000',
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
            'client_id' => 'Client id',
            'client_name' => 'Client name',
            'supplier_id' => 'Supplier id',
            'supplier_name' => 'Supplier name',
            'po_number' => 'Po number',
            'po_date' => 'Po date',
            'po_type' => 'Po type',
            'po_amount' => 'Po amount',
            'po_discount' => 'Po discount',
            'persentase_supplier' => 'Persentase supplier',
            'status' => 'Status',
            'po_nett' => 'Po nett',
            'file_images' => 'File images',
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
            'file_images.required' => ':attribute diperlukan.',
            'file_images.mimes' => ':attribute file bukan .jpg,.jpeg,.png.',
            'file_images.max' => 'Ukuran file :attribute lebih dari 1mb.',
        ];
    }
}
