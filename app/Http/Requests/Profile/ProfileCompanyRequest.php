<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;

class ProfileCompanyRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'exists:users,email'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'country' => ['required', 'string', 'max:50'],
            'province' => ['required', 'string', 'max:50'],
            'regency' => ['required', 'string', 'max:50'],
            'district' => ['required', 'string', 'max:50'],
            'subdistrict' => ['required', 'string', 'max:50'],
            'postal_code' => ['required', 'string', 'max:20'],
            'address' => ['required', 'string', 'max:150'],
            'telephone' => ['nullable', 'string', 'max:20'],
            'handphone' => ['required', 'string', 'max:20'],
            'director' => ['required', 'string', 'max:50'],
            'position' => ['required', 'string', 'max:50'],
            'handphone_director' => ['required', 'string', 'max:20'],
            'person_in_charge' => ['required', 'string', 'max:50'],
            'handphone_person_in_charge' => ['required', 'string', 'max:20'],
            'imprint' => ['nullable'],
            'publisher' => ['nullable'],
            'category' => ['nullable'],
            'npwp' => ['required'],
            'account_bank' => ['required'],
            'bank' => ['required'],
            'account_name' => ['required'],
            'bank_city' => ['required'],
            'supplier' => ['nullable'],
            'distributor' => ['nullable'],
            'supp_distributor' => ['nullable'],
            'agreement' => ['nullable'],
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
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
            'country' => 'Country',
            'province' => 'Province',
            'regency' => 'Regency',
            'district' => 'District',
            'subdistrict' => 'Subdistrict',
            'postal_code' => 'Postal code',
            'address' => 'Address',
            'telephone' => 'Telephone',
            'handphone' => 'Handphone',
            'director' => 'Director',
            'position' => 'Position',
            'handphone_director' => 'Handphone director',
            'person_in_charge' => 'Person in charge',
            'handphone_person_in_charge' => 'Handphone person in charge',
            'imprint' => 'Imprint',
            'publisher' => 'Publisher',
            'category' => 'Category',
            'npwp' => 'Npwp',
            'account_bank' => 'Account bank',
            'bank' => 'Bank',
            'account_name' => 'Account name',
            'bank_city' => 'Bank city',
            'supplier' => 'Supplier',
            'distributor' => 'Distributor',
            'supp_distributor' => 'Supp distributor',
            'agreement' => 'Agreement',
        ];
    }
}
