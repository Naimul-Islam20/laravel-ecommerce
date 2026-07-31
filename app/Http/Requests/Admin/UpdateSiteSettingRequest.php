<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'site_name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'string', 'max:500'],
            'favicon' => ['nullable', 'string', 'max:500'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'about_text' => ['nullable', 'string', 'max:2000'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string', 'max:1000'],
            'map_url' => ['nullable', 'string', 'max:500'],
            'gstin' => ['nullable', 'string', 'max:50'],
            'facebook_url' => ['nullable', 'string', 'max:500'],
            'instagram_url' => ['nullable', 'string', 'max:500'],
            'youtube_url' => ['nullable', 'string', 'max:500'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:500'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $nullable = [
            'logo',
            'favicon',
            'company_name',
            'about_text',
            'phone',
            'email',
            'address',
            'map_url',
            'gstin',
            'facebook_url',
            'instagram_url',
            'youtube_url',
            'meta_title',
            'meta_description',
            'meta_keywords',
        ];

        $data = [];

        foreach ($nullable as $field) {
            if ($this->has($field) && trim((string) $this->input($field)) === '') {
                $data[$field] = null;
            }
        }

        if ($data !== []) {
            $this->merge($data);
        }
    }
}
