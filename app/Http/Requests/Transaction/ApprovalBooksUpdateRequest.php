<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;

class ApprovalBooksUpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'book_id' => 'required|exists:tbook_draft,book_id',
            'isbn' => 'required',
            'eisbn' => 'required',
            'title' => 'required',
            'writer' => 'required',
            'publisher_id' => 'required',
            'size' => 'required',
            'year' => 'required',
            'volume' => 'required',
            'edition' => 'required',
            'page' => 'required',
            'sinopsis' => 'required',
            'sellprice' => 'required|numeric',
            'rentprice' => 'required|numeric',
            'retailprice' => 'required|numeric',
            'city' => 'required',
            'category_id' => 'required',
            'age' => 'required|numeric',
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
            'book_id' => 'Book ID',
            'isbn' => 'ISBN',
            'eisbn' => 'EISBN',
            'title' => 'Judul',
            'writer' => 'Penulis',
            'publisher_id' => 'Publisher',
            'size' => 'Ukuran',
            'year' => 'Tahun',
            'volume' => 'Jilid',
            'edition' => 'Edisi',
            'page' => 'Halaman',
            'sinopsis' => 'sinopsis',
            'sellprice' => 'Harga Jual',
            'rentprice' => 'Harga Pinjam',
            'retailprice' => 'Harga Retail',
            'city' => 'Kota',
            'category_id' => 'Kategori',
            'age' => 'Umur',
        ];
    }
}
