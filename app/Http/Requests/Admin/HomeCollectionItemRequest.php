<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

abstract class HomeCollectionItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    protected function itemRules(?int $itemId = null): array
    {
        $type = $this->input('item_type');

        $categoryExists = Rule::exists('categories', 'id')->where('is_active', true);

        if ($type === 'category') {
            $categoryExists->whereNull('parent_id');
        } elseif ($type === 'subcategory') {
            $categoryExists->whereNotNull('parent_id');
        }

        return [
            'item_type' => ['required', Rule::in(['category', 'subcategory'])],
            'category_id' => [
                'required',
                'integer',
                $categoryExists,
                Rule::unique('home_collection_items', 'category_id')->ignore($itemId),
            ],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => filter_var($this->input('is_active', true), FILTER_VALIDATE_BOOLEAN),
            'sort_order' => $this->input('sort_order', 0),
        ]);
    }
}
