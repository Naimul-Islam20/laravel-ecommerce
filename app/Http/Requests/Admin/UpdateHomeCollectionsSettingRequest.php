<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHomeCollectionsSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'collections_columns' => ['required', 'integer', 'min:1', 'max:6'],
            'collections_rows' => ['required', 'integer', 'min:1', 'max:6'],
        ];
    }
}
