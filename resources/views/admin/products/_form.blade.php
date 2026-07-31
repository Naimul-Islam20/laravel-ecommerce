@php
    $pricingMode = old('pricing_mode', $product->pricing_mode ?: \App\Models\Product::PRICING_MODE_SINGLE);
    $existingPackages = collect($product->packOptions())
        ->map(fn ($pack) => [
            'label' => $pack['label'] ?? '',
            'price' => $pack['price'] ?? '',
        ])
        ->values()
        ->all();

    if (old('package_labels') !== null || old('package_prices') !== null) {
        $labels = (array) old('package_labels', []);
        $prices = (array) old('package_prices', []);
        $count = max(count($labels), count($prices));
        $packageRows = [];

        for ($i = 0; $i < $count; $i++) {
            $packageRows[] = [
                'label' => $labels[$i] ?? '',
                'price' => $prices[$i] ?? '',
            ];
        }
    } else {
        $packageRows = $existingPackages;
    }

    if ($packageRows === []) {
        $packageRows = [
            ['label' => '', 'price' => ''],
        ];
    }
@endphp

<div class="grid gap-6 lg:grid-cols-2">
    <div class="space-y-4 lg:col-span-2">
        <div class="grid gap-4 md:grid-cols-2">
            <div>
                <label for="name" class="mb-1 block text-sm font-medium">Name *</label>
                <input id="name" name="name" type="text" value="{{ old('name', $product->name) }}" required
                       class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="slug" class="mb-1 block text-sm font-medium">Slug</label>
                <input id="slug" name="slug" type="text" value="{{ old('slug', $product->slug) }}"
                       class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm" placeholder="Auto-generated if empty">
                @error('slug')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="category_id" class="mb-1 block text-sm font-medium">Category *</label>
                <select id="category_id" name="category_id" required class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
                    <option value="">Select category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="brand" class="mb-1 block text-sm font-medium">Brand</label>
                <input id="brand" name="brand" type="text" value="{{ old('brand', $product->brand) }}"
                       class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
                @error('brand')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="currency" class="mb-1 block text-sm font-medium">Currency *</label>
                <input id="currency" name="currency" type="text" value="{{ old('currency', $product->currency ?? 'USD') }}" required
                       class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
                @error('currency')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="image" class="mb-1 block text-sm font-medium">Image Path</label>
                <input id="image" name="image" type="text" value="{{ old('image', $product->image) }}"
                       class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm" placeholder="images/item-1.webp">
                @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="sort_order" class="mb-1 block text-sm font-medium">Sort Order</label>
                <input id="sort_order" name="sort_order" type="number" min="0"
                       value="{{ old('sort_order', $product->sort_order ?? 0) }}"
                       class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
                @error('sort_order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="rounded-xl border border-brand-ink/10 bg-brand-mist/20 p-5" data-pricing-mode-root>
            <div class="mb-4">
                <h3 class="font-display text-base font-semibold">Pricing Setup</h3>
                <p class="mt-1 text-sm text-brand-ink/60">Choose a single price or set different prices for multiple packages.</p>
            </div>

            <div class="grid gap-3 md:grid-cols-2">
                <label class="flex items-start gap-3 rounded-lg border border-brand-ink/10 bg-white p-4">
                    <input type="radio" name="pricing_mode" value="{{ \App\Models\Product::PRICING_MODE_SINGLE }}"
                           data-pricing-mode-radio
                           @checked($pricingMode === \App\Models\Product::PRICING_MODE_SINGLE)>
                    <span>
                        <span class="block text-sm font-medium text-brand-ink">Single Product Price</span>
                        <span class="mt-1 block text-xs text-brand-ink/60">Show one fixed price on the product page.</span>
                    </span>
                </label>

                <label class="flex items-start gap-3 rounded-lg border border-brand-ink/10 bg-white p-4">
                    <input type="radio" name="pricing_mode" value="{{ \App\Models\Product::PRICING_MODE_MULTIPLE }}"
                           data-pricing-mode-radio
                           @checked($pricingMode === \App\Models\Product::PRICING_MODE_MULTIPLE)>
                    <span>
                        <span class="block text-sm font-medium text-brand-ink">Multiple Packages</span>
                        <span class="mt-1 block text-xs text-brand-ink/60">Add package names with separate prices for each option.</span>
                    </span>
                </label>
            </div>
            @error('pricing_mode')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror

            <div class="mt-4" data-single-price-section @if ($pricingMode !== \App\Models\Product::PRICING_MODE_SINGLE) hidden @endif>
                <label for="single_price" class="mb-1 block text-sm font-medium">Single Price *</label>
                <input id="single_price" name="single_price" type="number" step="0.01" min="0"
                       value="{{ old('single_price', $pricingMode === \App\Models\Product::PRICING_MODE_SINGLE ? $product->price_from : '') }}"
                       class="w-full rounded-lg border border-brand-ink/15 bg-white px-3 py-2 text-sm">
                @error('single_price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="mt-4 space-y-4" data-multiple-prices-section @if ($pricingMode !== \App\Models\Product::PRICING_MODE_MULTIPLE) hidden @endif>
                <div class="flex items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-medium text-brand-ink">Package Prices</p>
                        <p class="text-xs text-brand-ink/60">Example: `Pack of 25`, `Pack of 50`, `Carton Pack` with different prices.</p>
                    </div>
                    <button type="button" class="rounded-lg border border-brand-ink/15 px-3 py-2 text-sm" data-add-package-row>
                        Add Package
                    </button>
                </div>

                <div class="space-y-3" data-package-rows>
                    @foreach ($packageRows as $index => $packageRow)
                        <div class="grid gap-3 rounded-lg border border-brand-ink/10 bg-white p-3 md:grid-cols-[minmax(0,1fr)_180px_auto]">
                            <div>
                                <label class="mb-1 block text-xs font-medium text-brand-ink/60">Package Name</label>
                                <input type="text" name="package_labels[]" value="{{ $packageRow['label'] }}"
                                       class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm"
                                       placeholder="Pack of 25">
                                @error("package_labels.$index")<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="mb-1 block text-xs font-medium text-brand-ink/60">Price</label>
                                <input type="number" name="package_prices[]" value="{{ $packageRow['price'] }}"
                                       step="0.01" min="0"
                                       class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm"
                                       placeholder="199">
                                @error("package_prices.$index")<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>
                            <div class="flex items-end">
                                <button type="button" class="rounded-lg border border-red-200 px-3 py-2 text-sm text-red-600" data-remove-package-row>
                                    Remove
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                @error('package_labels')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label for="short_description" class="mb-1 block text-sm font-medium">Short Description</label>
            <textarea id="short_description" name="short_description" rows="2"
                      class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">{{ old('short_description', $product->short_description) }}</textarea>
            @error('short_description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="description" class="mb-1 block text-sm font-medium">Description (HTML allowed)</label>
            <textarea id="description" name="description" rows="5"
                      class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">{{ old('description', $product->description) }}</textarea>
            @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="gallery" class="mb-1 block text-sm font-medium">Gallery (JSON array)</label>
            <textarea id="gallery" name="gallery" rows="3"
                      class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 font-mono text-xs">{{ old('gallery', $product->gallery ? json_encode($product->gallery, JSON_PRETTY_PRINT) : '') }}</textarea>
            @error('gallery')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="rounded-xl border border-brand-ink/10 bg-white p-5 lg:col-span-2">
        <h3 class="mb-1 font-display text-base font-semibold">Home Section Flags</h3>
        <p class="mb-4 text-xs text-brand-ink/50">
            These come from Home Page → Flag sections. Category sections load products automatically.
        </p>
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($flagSections as $flagSection)
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="home_section_ids[]" value="{{ $flagSection->id }}"
                           @checked(in_array($flagSection->id, old('home_section_ids', $selectedHomeSectionIds ?? []), true))>
                    {{ $flagSection->title }}
                </label>
            @empty
                <p class="text-sm text-brand-ink/50 sm:col-span-2 lg:col-span-3">
                    No flag sections yet. Create one from Home Page → Add Section → Flag.
                </p>
            @endforelse
            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="is_active" value="1"
                       @checked(old('is_active', $product->is_active ?? true))>
                Active
            </label>
        </div>
        @error('home_section_ids')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        @error('home_section_ids.*')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<template data-package-row-template>
    <div class="grid gap-3 rounded-lg border border-brand-ink/10 bg-white p-3 md:grid-cols-[minmax(0,1fr)_180px_auto]">
        <div>
            <label class="mb-1 block text-xs font-medium text-brand-ink/60">Package Name</label>
            <input type="text" name="package_labels[]" class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm" placeholder="Pack of 25">
        </div>
        <div>
            <label class="mb-1 block text-xs font-medium text-brand-ink/60">Price</label>
            <input type="number" name="package_prices[]" step="0.01" min="0" class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm" placeholder="199">
        </div>
        <div class="flex items-end">
            <button type="button" class="rounded-lg border border-red-200 px-3 py-2 text-sm text-red-600" data-remove-package-row>
                Remove
            </button>
        </div>
    </div>
</template>

<div class="mt-6 flex items-center gap-3">
    <button type="submit" class="rounded-lg bg-brand-ink px-4 py-2 text-sm font-medium text-white hover:bg-brand-ink/90">
        Save Product
    </button>
    <a href="{{ route('admin.products.index') }}" class="text-sm text-brand-ink/60 hover:text-brand-ink">Cancel</a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const root = document.querySelector('[data-pricing-mode-root]');
        if (!root) return;

        const radios = root.querySelectorAll('[data-pricing-mode-radio]');
        const singleSection = root.querySelector('[data-single-price-section]');
        const multipleSection = root.querySelector('[data-multiple-prices-section]');
        const rowsWrap = root.querySelector('[data-package-rows]');
        const addBtn = root.querySelector('[data-add-package-row]');
        const template = document.querySelector('[data-package-row-template]');

        const syncSections = () => {
            const mode = root.querySelector('[data-pricing-mode-radio]:checked')?.value;
            const isSingle = mode === '{{ \App\Models\Product::PRICING_MODE_SINGLE }}';

            if (singleSection) singleSection.hidden = !isSingle;
            if (multipleSection) multipleSection.hidden = isSingle;
        };

        const ensureOneRow = () => {
            if (!rowsWrap || rowsWrap.children.length > 0 || !template) return;
            rowsWrap.appendChild(template.content.firstElementChild.cloneNode(true));
        };

        radios.forEach((radio) => radio.addEventListener('change', syncSections));
        syncSections();

        addBtn?.addEventListener('click', () => {
            if (!rowsWrap || !template) return;
            rowsWrap.appendChild(template.content.firstElementChild.cloneNode(true));
        });

        rowsWrap?.addEventListener('click', (event) => {
            const button = event.target.closest('[data-remove-package-row]');
            if (!button) return;

            button.closest('.grid')?.remove();
            ensureOneRow();
        });

        ensureOneRow();
    });
</script>
