<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:books',
            'total_copies' => 'required|integer|min:1',
            'available_copies' => 'required|integer|min:0',
            'category' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Book title is required',
            'author.required' => 'Book author is required',
            'isbn.required' => 'ISBN is required',
            'isbn.unique' => 'This ISBN already exists',
            'total_copies.required' => 'Total copies is required',
            'total_copies.min' => 'Total copies must be at least 1',
            'available_copies.required' => 'Available copies is required',
            'available_copies.min' => 'Available copies cannot be negative',
        ];
    }
}
