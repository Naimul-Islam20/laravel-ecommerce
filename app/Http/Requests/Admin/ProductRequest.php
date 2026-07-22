<?php

namespace App\Http\Requests\Admin;

use App\Models\HomeSection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

abstract class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    protected function productRules(?int $productId = null): array
    {
        return [
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')],
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['nullable', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($productId),
            ],
            'image' => ['nullable', 'string', 'max:500'],
            'short_description' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string'],
            'gallery' => ['nullable', 'string'],
            'pack_options' => ['nullable', 'string'],
            'price_from' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:10'],
            'is_active' => ['sometimes', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'home_section_ids' => ['nullable', 'array'],
            'home_section_ids.*' => [
                'integer',
                Rule::exists('home_sections', 'id')->where('type', HomeSection::TYPE_FLAG),
            ],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'home_section_ids' => array_values(array_filter(
                array_map('intval', (array) $this->input('home_section_ids', []))
            )),
        ]);
    }

    public function validatedPayload(): array
    {
        $data = $this->validated();

        unset($data['home_section_ids']);

        $data['gallery'] = $this->decodeJsonField('gallery');
        $data['pack_options'] = $this->decodeJsonField('pack_options');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }

    public function homeSectionIds(): array
    {
        return $this->validated('home_section_ids') ?? [];
    }

    private function decodeJsonField(string $field): ?array
    {
        $value = $this->input($field);

        if ($value === null || $value === '') {
            return null;
        }

        if (is_array($value)) {
            return $value;
        }

        $decoded = json_decode($value, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                $field => ['Invalid JSON format.'],
            ]);
        }

        return $decoded;
    }
}
