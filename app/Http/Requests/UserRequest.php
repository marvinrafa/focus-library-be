<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        $emailRule = 'required|email|unique:users';
        if ($this->isMethod('put')) {
            $id = $this->route('id');
            $sometimes = 'sometimes|';
            $emailRule = ['sometimes', 'required', 'email', Rule::unique('users')->ignore($id)];
        }
        return [
            'first_name' => $sometimes . 'required|min:2',
            'last_name' => $sometimes . 'required|min:2',
            'email' => $emailRule,
            'role' => $sometimes . 'required|string|in:' . implode(",", User::ROLES),
        ];
    }
}
