@php
    $selectedCategoryId = (int) old('category_id', $item->category_id);
    $selectedCategory = $item->relationLoaded('category')
        ? $item->category
        : ($item->category_id ? \App\Models\Category::find($item->category_id) : null);

    $itemType = old(
        'item_type',
        $selectedCategory
            ? ($selectedCategory->parent_id ? 'subcategory' : 'category')
            : ''
    );

    $statusValue = (int) old('is_active', ($item->is_active ?? true) ? 1 : 0);
@endphp

<div class="grid gap-4 md:grid-cols-2" data-collection-item-form>
    <div>
        <label for="item_type" class="mb-1 block text-sm font-medium">Type *</label>
        <select id="item_type" name="item_type" required class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm" data-item-type>
            <option value="">Select type</option>
            <option value="category" @selected($itemType === 'category')>Category</option>
            <option value="subcategory" @selected($itemType === 'subcategory')>SubCategory</option>
        </select>
        @error('item_type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="is_active" class="mb-1 block text-sm font-medium">Status *</label>
        <select id="is_active" name="is_active" required class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
            <option value="1" @selected($statusValue === 1)>Active</option>
            <option value="0" @selected($statusValue === 0)>Inactive</option>
        </select>
        @error('is_active')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div data-category-field class="md:col-span-2" @if ($itemType !== 'category') hidden @endif>
        <label for="category_select" class="mb-1 block text-sm font-medium">Category *</label>
        <select id="category_select" class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm" data-category-select @if ($itemType !== 'category') disabled @endif>
            <option value="">Select category</option>
            @foreach ($parentCategories as $category)
                <option value="{{ $category->id }}" @selected($itemType === 'category' && $selectedCategoryId === (int) $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>

    <div data-subcategory-field class="md:col-span-2" @if ($itemType !== 'subcategory') hidden @endif>
        <label for="subcategory_select" class="mb-1 block text-sm font-medium">SubCategory *</label>
        <select id="subcategory_select" class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm" data-subcategory-select @if ($itemType !== 'subcategory') disabled @endif>
            <option value="">Select subcategory</option>
            @foreach ($subcategories as $subcategory)
                <option value="{{ $subcategory->id }}" @selected($itemType === 'subcategory' && $selectedCategoryId === (int) $subcategory->id)>
                    {{ $subcategory->parent?->name ? $subcategory->parent->name.' › ' : '' }}{{ $subcategory->name }}
                </option>
            @endforeach
        </select>
    </div>

    <input type="hidden" name="category_id" value="{{ $selectedCategoryId ?: '' }}" data-category-id>
    @error('category_id')<p class="md:col-span-2 text-sm text-red-600">{{ $message }}</p>@enderror

    <div>
        <label for="sort_order" class="mb-1 block text-sm font-medium">Sort Order</label>
        <input id="sort_order" name="sort_order" type="number" min="0"
               value="{{ old('sort_order', $item->sort_order ?? 0) }}"
               class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
        @error('sort_order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-6 flex items-center gap-3">
    <button type="submit" class="rounded-lg bg-brand-ink px-4 py-2 text-sm font-medium text-white">Save Collection Item</button>
    <a href="{{ route('admin.home-page.index') }}" class="text-sm text-brand-ink/60 hover:text-brand-ink">Cancel</a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const root = document.querySelector('[data-collection-item-form]');
        if (!root) return;

        const typeSelect = root.querySelector('[data-item-type]');
        const categoryField = root.querySelector('[data-category-field]');
        const subcategoryField = root.querySelector('[data-subcategory-field]');
        const categorySelect = root.querySelector('[data-category-select]');
        const subcategorySelect = root.querySelector('[data-subcategory-select]');
        const hiddenCategoryId = root.querySelector('[data-category-id]');

        const sync = () => {
            const type = typeSelect.value;

            categoryField.hidden = type !== 'category';
            subcategoryField.hidden = type !== 'subcategory';

            categorySelect.disabled = type !== 'category';
            subcategorySelect.disabled = type !== 'subcategory';

            if (type === 'category') {
                hiddenCategoryId.value = categorySelect.value || '';
            } else if (type === 'subcategory') {
                hiddenCategoryId.value = subcategorySelect.value || '';
            } else {
                hiddenCategoryId.value = '';
            }
        };

        typeSelect.addEventListener('change', () => {
            if (typeSelect.value !== 'category') categorySelect.value = '';
            if (typeSelect.value !== 'subcategory') subcategorySelect.value = '';
            sync();
        });

        categorySelect.addEventListener('change', sync);
        subcategorySelect.addEventListener('change', sync);

        sync();
    });
</script>
