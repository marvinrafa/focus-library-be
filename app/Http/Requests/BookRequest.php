<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $sometimes = '';
        if ($this->isMethod('put')) {
            $sometimes = 'sometimes|';
        }
        return [
            'title' => $sometimes . 'required|string|min:2',
            'year' => $sometimes . 'required|integer',
            'published' => $sometimes . 'required|boolean',
            'author_id' => $sometimes . 'required|exists:authors,id',
            'genre_id' => $sometimes . 'required|exists:genres,id',
            'base_stock' => $sometimes . 'required|integer',
        ];
    }
}
