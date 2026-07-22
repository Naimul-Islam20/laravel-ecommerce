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
                <label for="price_from" class="mb-1 block text-sm font-medium">Price From *</label>
                <input id="price_from" name="price_from" type="number" step="0.01" min="0"
                       value="{{ old('price_from', $product->price_from) }}" required
                       class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
                @error('price_from')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
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

        <div>
            <label for="pack_options" class="mb-1 block text-sm font-medium">Pack Options (JSON array)</label>
            <textarea id="pack_options" name="pack_options" rows="4"
                      class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 font-mono text-xs">{{ old('pack_options', $product->pack_options ? json_encode($product->pack_options, JSON_PRETTY_PRINT) : '') }}</textarea>
            @error('pack_options')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
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

<div class="mt-6 flex items-center gap-3">
    <button type="submit" class="rounded-lg bg-brand-ink px-4 py-2 text-sm font-medium text-white hover:bg-brand-ink/90">
        Save Product
    </button>
    <a href="{{ route('admin.products.index') }}" class="text-sm text-brand-ink/60 hover:text-brand-ink">Cancel</a>
</div>
