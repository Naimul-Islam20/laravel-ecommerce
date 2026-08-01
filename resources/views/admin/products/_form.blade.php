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
        </div>

        @php
            $existingProductImages = [];
            if ($product->exists) {
                if ($product->image) {
                    $existingProductImages[] = $product->image;
                }
                foreach ($product->gallery ?? [] as $galleryPath) {
                    if ($galleryPath && ! in_array($galleryPath, $existingProductImages, true)) {
                        $existingProductImages[] = $galleryPath;
                    }
                }
            }
            if ($existingProductImages === []) {
                $existingProductImages = [null];
            }
        @endphp

        <div class="grid gap-6 lg:grid-cols-2">
            <div data-product-images-root>
                <h3 class="mb-1 font-display text-base font-semibold">Images</h3>
                <div class="rounded-xl border border-brand-ink/10 bg-white p-5">
                    <div class="space-y-4" data-image-rows>
                        @foreach ($existingProductImages as $index => $imagePath)
                            <div class="flex flex-wrap items-start gap-3" data-image-row>
                                <div class="min-w-0 flex-1">
                                    <label class="mb-1 block text-sm font-medium">
                                        {{ $index === 0 ? 'Image' : 'Image '.($index + 1) }}
                                    </label>
                                    <input type="hidden" name="existing_images[{{ $index }}]" value="{{ $imagePath }}">
                                    <input type="file" name="product_images[{{ $index }}]" accept="image/*"
                                           class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm file:mr-3 file:rounded file:border-0 file:bg-brand-mist file:px-3 file:py-1.5 file:text-sm"
                                           data-image-input>
                                    @if ($index === 0)
                                        <p class="mt-1 text-xs text-brand-ink/50">JPG, PNG, WEBP. Max 5MB.</p>
                                    @endif
                                </div>
                                <div class="pt-6">
                                    <img
                                        src="{{ $imagePath ? $product->galleryPathUrl($imagePath) : '' }}"
                                        alt=""
                                        class="h-12 w-12 rounded border border-brand-ink/10 object-cover {{ $imagePath ? '' : 'hidden' }}"
                                        data-image-preview
                                    >
                                    <div class="flex h-12 w-12 items-center justify-center rounded border border-dashed border-brand-ink/20 text-[9px] text-brand-ink/40 {{ $imagePath ? 'hidden' : '' }}" data-image-placeholder>
                                        Preview
                                    </div>
                                </div>
                                <button type="button" class="mt-7 text-sm text-red-600 {{ count($existingProductImages) === 1 ? 'invisible' : '' }}" data-remove-image-row>
                                    Remove
                                </button>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" class="mt-4 rounded-lg border border-brand-ink/15 px-3 py-2 text-sm" data-add-image-row>
                        Add another image
                    </button>

                    @error('product_images')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    @error('product_images.*')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                    @error('existing_images')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="space-y-4 rounded-xl border border-brand-ink/10 bg-white p-5" data-pricing-mode-root>
                <div>
                    <label for="pricing_mode" class="mb-1 block text-sm font-medium">Price Type *</label>
                    <select id="pricing_mode" name="pricing_mode" data-pricing-mode-select
                            class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
                        <option value="{{ \App\Models\Product::PRICING_MODE_SINGLE }}"
                            @selected($pricingMode === \App\Models\Product::PRICING_MODE_SINGLE)>
                            Single price
                        </option>
                        <option value="{{ \App\Models\Product::PRICING_MODE_MULTIPLE }}"
                            @selected($pricingMode === \App\Models\Product::PRICING_MODE_MULTIPLE)>
                            Multiple packages
                        </option>
                    </select>
                    @error('pricing_mode')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div data-single-price-section @if ($pricingMode !== \App\Models\Product::PRICING_MODE_SINGLE) hidden @endif>
                    <label for="single_price" class="mb-1 block text-sm font-medium">Price *</label>
                    <input id="single_price" name="single_price" type="number" step="0.01" min="0"
                           value="{{ old('single_price', $pricingMode === \App\Models\Product::PRICING_MODE_SINGLE ? $product->price_from : '') }}"
                           class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm"
                           placeholder="199">
                    @error('single_price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div data-multiple-prices-section @if ($pricingMode !== \App\Models\Product::PRICING_MODE_MULTIPLE) hidden @endif>
                    <label class="mb-2 block text-sm font-medium">Packages</label>

                    <div class="mb-1 flex items-center gap-2 text-xs font-medium text-brand-ink/60">
                        <span style="width: 180px;">Pcs</span>
                        <span style="width: 120px;">Price</span>
                        <span class="w-16 shrink-0 text-right">Remove</span>
                    </div>

                    <div class="space-y-4" data-package-rows>
                        @foreach ($packageRows as $index => $packageRow)
                            <div class="flex items-center gap-2" data-package-row>
                                <input type="text" name="package_labels[]" value="{{ $packageRow['label'] }}"
                                       style="width: 180px;"
                                       class="rounded-lg border border-brand-ink/15 px-3 py-2 text-sm"
                                       placeholder="25 Pcs">
                                <input type="number" name="package_prices[]" value="{{ $packageRow['price'] }}"
                                       step="0.01" min="0"
                                       style="width: 120px;"
                                       class="shrink-0 rounded-lg border border-brand-ink/15 px-3 py-2 text-sm"
                                       placeholder="199">
                                <button type="button" class="w-16 shrink-0 text-right text-sm text-red-600" data-remove-package-row>
                                    Remove
                                </button>
                            </div>
                            @error("package_labels.$index")<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                            @error("package_prices.$index")<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        @endforeach
                    </div>

                    <button type="button" class="mt-3 text-sm text-brand-ink underline underline-offset-2" data-add-package-row>
                        + Add package
                    </button>

                    @error('package_labels')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        <div class="flex items-start gap-4">
            <div class="min-w-0 flex-1">
                <label for="description" class="mb-1 block text-sm font-medium">Description</label>
                <textarea id="description" name="description" rows="8"
                          class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">{{ old('description', $product->description) }}</textarea>
                @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="w-56 shrink-0">
                <p class="mb-1 text-sm font-medium">Formatting rules</p>
                <aside class="rounded-xl border border-dashed border-brand-ink/20 bg-brand-mist/40 p-4" aria-label="Description formatting rules">
                    <ul class="space-y-2 text-xs leading-relaxed text-brand-ink/70">
                        <li>
                            <code class="rounded bg-white px-1 py-0.5 text-brand-ink">*text*</code>
                            → bold
                        </li>
                    </ul>
                </aside>
            </div>
        </div>
    </div>

    <div class="lg:col-span-2">
        <h3 class="mb-1 font-display text-base font-semibold">Home Section Flags</h3>
        <div class="rounded-xl border border-brand-ink/10 bg-white p-5">
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
            </div>
            @error('home_section_ids')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
            @error('home_section_ids.*')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2 lg:col-span-2">
        <div>
            <label for="sort_order" class="mb-1 block text-sm font-medium">Sort Order</label>
            <input id="sort_order" name="sort_order" type="number" min="0"
                   value="{{ old('sort_order', $product->sort_order ?? 0) }}"
                   class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
            @error('sort_order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="is_active" class="mb-1 block text-sm font-medium">Status</label>
            @php
                $statusValue = (int) old('is_active', ($product->is_active ?? true) ? 1 : 0);
            @endphp
            <select id="is_active" name="is_active" class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
                <option value="1" @selected($statusValue === 1)>Active</option>
                <option value="0" @selected($statusValue === 0)>Inactive</option>
            </select>
            @error('is_active')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
    </div>
</div>

<template data-package-row-template>
    <div class="flex items-center gap-2" data-package-row>
        <input type="text" name="package_labels[]" style="width: 180px;" class="rounded-lg border border-brand-ink/15 px-3 py-2 text-sm" placeholder="25 Pcs">
        <input type="number" name="package_prices[]" step="0.01" min="0" style="width: 120px;" class="shrink-0 rounded-lg border border-brand-ink/15 px-3 py-2 text-sm" placeholder="199">
        <button type="button" class="w-16 shrink-0 text-right text-sm text-red-600" data-remove-package-row>
            Remove
        </button>
    </div>
</template>

<template data-image-row-template>
    <div class="flex flex-wrap items-start gap-3" data-image-row>
        <div class="min-w-0 flex-1">
            <label class="mb-1 block text-sm font-medium">Image</label>
            <input type="hidden" name="existing_images[]" value="" data-existing-image>
            <input type="file" name="product_images[]" accept="image/*"
                   class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm file:mr-3 file:rounded file:border-0 file:bg-brand-mist file:px-3 file:py-1.5 file:text-sm"
                   data-image-input>
        </div>
        <div class="pt-6">
            <img src="" alt="" class="hidden h-12 w-12 rounded border border-brand-ink/10 object-cover" data-image-preview>
            <div class="flex h-12 w-12 items-center justify-center rounded border border-dashed border-brand-ink/20 text-[9px] text-brand-ink/40" data-image-placeholder>
                Preview
            </div>
        </div>
        <button type="button" class="mt-7 text-sm text-red-600" data-remove-image-row>
            Remove
        </button>
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
        const pricingRoot = document.querySelector('[data-pricing-mode-root]');
        if (pricingRoot) {
            const modeSelect = pricingRoot.querySelector('[data-pricing-mode-select]');
            const singleSection = pricingRoot.querySelector('[data-single-price-section]');
            const multipleSection = pricingRoot.querySelector('[data-multiple-prices-section]');
            const rowsWrap = pricingRoot.querySelector('[data-package-rows]');
            const addBtn = pricingRoot.querySelector('[data-add-package-row]');
            const template = document.querySelector('[data-package-row-template]');

            const syncSections = () => {
                const isSingle = modeSelect?.value === '{{ \App\Models\Product::PRICING_MODE_SINGLE }}';
                if (singleSection) singleSection.hidden = !isSingle;
                if (multipleSection) multipleSection.hidden = isSingle;
            };

            const ensureOneRow = () => {
                if (!rowsWrap || rowsWrap.children.length > 0 || !template) return;
                rowsWrap.appendChild(template.content.firstElementChild.cloneNode(true));
            };

            modeSelect?.addEventListener('change', syncSections);
            syncSections();

            addBtn?.addEventListener('click', () => {
                if (!rowsWrap || !template) return;
                rowsWrap.appendChild(template.content.firstElementChild.cloneNode(true));
            });

            rowsWrap?.addEventListener('click', (event) => {
                const button = event.target.closest('[data-remove-package-row]');
                if (!button) return;
                button.closest('[data-package-row]')?.remove();
                ensureOneRow();
            });

            ensureOneRow();
        }

        const imagesRoot = document.querySelector('[data-product-images-root]');
        if (imagesRoot) {
            const rowsWrap = imagesRoot.querySelector('[data-image-rows]');
            const addBtn = imagesRoot.querySelector('[data-add-image-row]');
            const template = document.querySelector('[data-image-row-template]');
            let nextIndex = rowsWrap?.querySelectorAll('[data-image-row]').length || 0;

            const syncRowLabels = () => {
                rowsWrap?.querySelectorAll('[data-image-row]').forEach((row, index) => {
                    const label = row.querySelector('label');
                    if (label) label.textContent = index === 0 ? 'Image' : `Image ${index + 1}`;

                    const removeBtn = row.querySelector('[data-remove-image-row]');
                    if (removeBtn) {
                        removeBtn.classList.toggle('invisible', rowsWrap.children.length === 1);
                    }
                });
            };

            const bindPreview = (row) => {
                const input = row.querySelector('[data-image-input]');
                const preview = row.querySelector('[data-image-preview]');
                const placeholder = row.querySelector('[data-image-placeholder]');
                if (!input || !preview || !placeholder) return;

                input.addEventListener('change', () => {
                    const file = input.files?.[0];
                    if (!file) return;

                    const url = URL.createObjectURL(file);
                    preview.src = url;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                });
            };

            const reindexRows = () => {
                rowsWrap?.querySelectorAll('[data-image-row]').forEach((row, index) => {
                    const existing = row.querySelector('input[type="hidden"]');
                    const file = row.querySelector('input[type="file"]');
                    if (existing) existing.name = `existing_images[${index}]`;
                    if (file) file.name = `product_images[${index}]`;
                });
                nextIndex = rowsWrap?.querySelectorAll('[data-image-row]').length || 0;
            };

            rowsWrap?.querySelectorAll('[data-image-row]').forEach((row) => bindPreview(row));
            syncRowLabels();

            addBtn?.addEventListener('click', () => {
                if (!rowsWrap || !template) return;
                const row = template.content.firstElementChild.cloneNode(true);
                const existing = row.querySelector('[data-existing-image], input[type="hidden"]');
                const file = row.querySelector('[data-image-input]');
                if (existing) {
                    existing.name = `existing_images[${nextIndex}]`;
                    existing.value = '';
                }
                if (file) file.name = `product_images[${nextIndex}]`;
                nextIndex += 1;
                rowsWrap.appendChild(row);
                bindPreview(row);
                reindexRows();
                syncRowLabels();
            });

            rowsWrap?.addEventListener('click', (event) => {
                const button = event.target.closest('[data-remove-image-row]');
                if (!button) return;
                if (rowsWrap.children.length <= 1) return;
                button.closest('[data-image-row]')?.remove();
                reindexRows();
                syncRowLabels();
            });
        }
    });
</script>
