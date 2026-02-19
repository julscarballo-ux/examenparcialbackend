<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLoanRequest extends FormRequest
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
            'nombre_solicitante' => ['required', 'string', 'max:255'],
            'book_id' => ['required', 'integer', 'exists:books,id'],
            'fecha_prestamo' => ['required', 'date'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'nombre_solicitante' => 'nombre del solicitante',
            'book_id' => 'libro',
            'fecha_prestamo' => 'fecha de préstamo',
        ];
    }
}