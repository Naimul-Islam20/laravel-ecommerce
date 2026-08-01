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
            'product_images' => ['nullable', 'array'],
            'product_images.*' => ['nullable', 'image', 'max:5120'],
            'existing_images' => ['nullable', 'array'],
            'existing_images.*' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'pricing_mode' => ['required', Rule::in([Product::PRICING_MODE_SINGLE, Product::PRICING_MODE_MULTIPLE])],
            'single_price' => ['nullable', 'numeric', 'min:0'],
            'package_labels' => ['nullable', 'array'],
            'package_labels.*' => ['nullable', 'string', 'max:100'],
            'package_prices' => ['nullable', 'array'],
            'package_prices.*' => ['nullable', 'numeric', 'min:0'],
            'is_active' => ['required', 'boolean'],
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
            'is_active' => filter_var($this->input('is_active', true), FILTER_VALIDATE_BOOLEAN),
            'home_section_ids' => array_values(array_filter(
                array_map('intval', (array) $this->input('home_section_ids', []))
            )),
        ]);
    }

    public function validatedPayload(): array
    {
        $data = $this->validated();

        unset(
            $data['home_section_ids'],
            $data['single_price'],
            $data['package_labels'],
            $data['package_prices'],
            $data['product_images'],
            $data['existing_images'],
        );

        $data['pack_options'] = $this->buildPackOptions($data['pricing_mode']);
        $data['price_from'] = $this->resolvePriceFrom($data['pricing_mode'], $data['pack_options']);
        $site = \App\Models\SiteSetting::current();
        $data['currency'] = $site->currencyLabel();
        $data['brand'] = trim((string) $site->site_name) ?: 'XPERCIAINC';
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }

    public function homeSectionIds(): array
    {
        return $this->validated('home_section_ids') ?? [];
    }

    /**
     * @return array{0: array<int, string>, 1: array<int, \Illuminate\Http\UploadedFile>}
     */
    public function imageRowPayload(): array
    {
        $existing = (array) $this->input('existing_images', []);
        $files = (array) $this->file('product_images', []);
        $indexes = array_values(array_unique([...array_keys($existing), ...array_keys($files)]));
        sort($indexes, SORT_NUMERIC);

        $keptExisting = [];
        $uploadsByIndex = [];

        foreach ($indexes as $index) {
            $file = $files[$index] ?? null;
            $path = trim((string) ($existing[$index] ?? ''));

            if ($file instanceof \Illuminate\Http\UploadedFile && $file->isValid()) {
                $uploadsByIndex[(int) $index] = $file;
                continue;
            }

            if ($path !== '') {
                $keptExisting[(int) $index] = $path;
            }
        }

        return [$keptExisting, $uploadsByIndex];
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
