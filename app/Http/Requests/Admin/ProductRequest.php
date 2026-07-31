<?php

namespace App\Http\Requests\Admin;

use App\Models\HomeSection;
use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

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
            'pricing_mode' => ['required', Rule::in([Product::PRICING_MODE_SINGLE, Product::PRICING_MODE_MULTIPLE])],
            'single_price' => ['nullable', 'numeric', 'min:0'],
            'package_labels' => ['nullable', 'array'],
            'package_labels.*' => ['nullable', 'string', 'max:100'],
            'package_prices' => ['nullable', 'array'],
            'package_prices.*' => ['nullable', 'numeric', 'min:0'],
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
            'pricing_mode' => $this->input('pricing_mode', Product::PRICING_MODE_SINGLE),
            'is_active' => $this->boolean('is_active'),
            'home_section_ids' => array_values(array_filter(
                array_map('intval', (array) $this->input('home_section_ids', []))
            )),
        ]);
    }

    public function validatedPayload(): array
    {
        $data = $this->validated();

        unset($data['home_section_ids'], $data['single_price'], $data['package_labels'], $data['package_prices']);

        $data['gallery'] = $this->decodeJsonField('gallery');
        $data['pack_options'] = $this->buildPackOptions($data['pricing_mode']);
        $data['price_from'] = $this->resolvePriceFrom($data['pricing_mode'], $data['pack_options']);
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

    private function buildPackOptions(string $pricingMode): ?array
    {
        if ($pricingMode === Product::PRICING_MODE_SINGLE) {
            return null;
        }

        $labels = (array) $this->input('package_labels', []);
        $prices = (array) $this->input('package_prices', []);
        $packages = [];
        $errors = [];
        $count = max(count($labels), count($prices));

        for ($index = 0; $index < $count; $index++) {
            $label = trim((string) ($labels[$index] ?? ''));
            $priceRaw = trim((string) ($prices[$index] ?? ''));

            if ($label === '' && $priceRaw === '') {
                continue;
            }

            if ($label === '') {
                $errors["package_labels.$index"] = ['Package name is required.'];
            }

            if ($priceRaw === '') {
                $errors["package_prices.$index"] = ['Package price is required.'];
            } elseif (! is_numeric($priceRaw) || (float) $priceRaw < 0) {
                $errors["package_prices.$index"] = ['Package price must be a valid number.'];
            }

            if ($label !== '' && $priceRaw !== '' && is_numeric($priceRaw) && (float) $priceRaw >= 0) {
                $packages[] = [
                    'label' => $label,
                    'price' => round((float) $priceRaw, 2),
                ];
            }
        }

        if ($packages === []) {
            $errors['package_labels'] = ['Add at least one package option for multiple pricing.'];
        }

        if ($errors !== []) {
            throw ValidationException::withMessages($errors);
        }

        return $packages;
    }

    private function resolvePriceFrom(string $pricingMode, ?array $packOptions): float
    {
        if ($pricingMode === Product::PRICING_MODE_SINGLE) {
            $singlePrice = $this->input('single_price');

            if ($singlePrice === null || $singlePrice === '' || ! is_numeric($singlePrice) || (float) $singlePrice < 0) {
                throw ValidationException::withMessages([
                    'single_price' => ['Single price is required.'],
                ]);
            }

            return round((float) $singlePrice, 2);
        }

        return round((float) min(array_column($packOptions ?? [], 'price')), 2);
    }
}
