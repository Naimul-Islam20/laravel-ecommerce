<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHomeSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'hero_cta_text' => ['required', 'string', 'max:100'],
            'hero_cta_url' => ['required', 'string', 'max:500'],
        ];
    }
}
