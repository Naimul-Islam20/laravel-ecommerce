<?php

namespace App\Http\Requests\Admin;

use App\Models\Category;
use App\Models\HomeSection;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreHomeSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        $catalogTypes = [HomeSection::TYPE_CATEGORY, HomeSection::TYPE_SUBCATEGORY];

        return [
            'type' => [
                'required',
                Rule::in([
                    HomeSection::TYPE_FLAG,
                    HomeSection::TYPE_CATEGORY,
                    HomeSection::TYPE_SUBCATEGORY,
                ]),
            ],
            'title' => [
                Rule::requiredIf(fn () => $this->input('type') === HomeSection::TYPE_FLAG),
                'nullable',
                'string',
                'max:255',
            ],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('home_sections', 'slug')],
            'category_id' => [
                Rule::requiredIf(fn () => in_array($this->input('type'), $catalogTypes, true)),
                'nullable',
                'integer',
                Rule::exists('categories', 'id'),
                Rule::unique('home_sections', 'category_id')
                    ->where(fn ($query) => $query->whereIn('type', $catalogTypes)),
            ],
            'product_limit' => ['nullable', 'integer', 'min:1', 'max:24'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['sometimes', 'boolean'],
            'show_view_all' => ['sometimes', 'boolean'],
            'grid_columns' => ['nullable', 'integer', Rule::in([3, 4, 5, 6])],
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            if (! $this->filled('category_id')) {
                return;
            }

            $category = Category::find($this->integer('category_id'));

            if (! $category) {
                return;
            }

            if ($this->input('type') === HomeSection::TYPE_CATEGORY && $category->parent_id !== null) {
                $validator->errors()->add('category_id', 'Please select a top-level category.');
            }

            if ($this->input('type') === HomeSection::TYPE_SUBCATEGORY && $category->parent_id === null) {
                $validator->errors()->add('category_id', 'Please select a subcategory.');
            }
        });
    }

    protected function prepareForValidation(): void
    {
        $merge = [
            'is_active' => $this->boolean('is_active'),
            'show_view_all' => $this->boolean('show_view_all'),
        ];

        $type = $this->input('type');

        if (in_array($type, [HomeSection::TYPE_CATEGORY, HomeSection::TYPE_SUBCATEGORY], true)
            && $this->filled('category_id')) {
            $categoryName = Category::where('id', $this->integer('category_id'))->value('name');
            if ($categoryName) {
                $merge['title'] = $categoryName;
            }
        }

        $this->merge($merge);
    }
}
