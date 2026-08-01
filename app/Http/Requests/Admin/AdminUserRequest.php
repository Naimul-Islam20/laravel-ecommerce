<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

abstract class AdminUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    protected function adminRules(?int $userId = null): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'is_active' => ['required', 'boolean'],
        ];

        if ($this->isMethod('post')) {
            $rules['password'] = ['required', 'string', 'min:6', 'confirmed'];
        } elseif ($this->filled('password')) {
            $rules['password'] = ['string', 'min:6', 'confirmed'];
        }

        return $rules;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => filter_var($this->input('is_active', true), FILTER_VALIDATE_BOOLEAN),
        ]);
    }
}
