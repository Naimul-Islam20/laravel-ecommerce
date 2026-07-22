<div class="grid gap-4 md:grid-cols-2">
    <div>
        <label for="type" class="mb-1 block text-sm font-medium">Section Type *</label>
        <select id="type" name="type" required class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
            <option value="flag" @selected(old('type', $section->type) === 'flag')>Flag (Home Section Flags)</option>
            <option value="category" @selected(old('type', $section->type) === 'category')>Category (auto products)</option>
            <option value="subcategory" @selected(old('type', $section->type) === 'subcategory')>SubCategory (auto products)</option>
        </select>
        @error('type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div id="title-field">
        <label for="title" class="mb-1 block text-sm font-medium">Section Title *</label>
        <input id="title" name="title" type="text" value="{{ old('title', $section->type === 'flag' ? $section->title : '') }}"
               class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm"
               placeholder="e.g. Best Seller, New Arrivals">
        <p class="mt-1 text-xs text-brand-ink/50">This name will appear as a checkbox on the product form.</p>
        @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div id="category-field">
        <label for="category_id" class="mb-1 block text-sm font-medium">Category *</label>
        <select id="category_id" name="category_id" class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
            <option value="">Select category</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $section->category_id) == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        <p class="mt-1 text-xs text-brand-ink/50">Top-level only. Name becomes section title. Includes subcategory products.</p>
        @error('category_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div id="subcategory-field">
        <label for="subcategory_id" class="mb-1 block text-sm font-medium">SubCategory *</label>
        <select id="subcategory_id" name="category_id" class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm" disabled>
            <option value="">Select subcategory</option>
            @foreach ($subcategories as $subcategory)
                <option value="{{ $subcategory->id }}" @selected(old('category_id', $section->category_id) == $subcategory->id)>
                    {{ $subcategory->name }}
                </option>
            @endforeach
        </select>
        <p class="mt-1 text-xs text-brand-ink/50">Name becomes section title. Newest products show first.</p>
        @error('category_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="slug" class="mb-1 block text-sm font-medium">Slug</label>
        <input id="slug" name="slug" type="text" value="{{ old('slug', $section->slug) }}"
               class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm" placeholder="Auto-generated if empty">
        @error('slug')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="product_limit" class="mb-1 block text-sm font-medium">Product Limit</label>
        <input id="product_limit" name="product_limit" type="number" min="1" max="24"
               value="{{ old('product_limit', $section->product_limit ?? 6) }}"
               class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
        @error('product_limit')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="sort_order" class="mb-1 block text-sm font-medium">Sort Order</label>
        <input id="sort_order" name="sort_order" type="number" min="0"
               value="{{ old('sort_order', $section->sort_order ?? 0) }}"
               class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
        @error('sort_order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="grid_columns" class="mb-1 block text-sm font-medium">Grid Columns</label>
        <select id="grid_columns" name="grid_columns" class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
            <option value="3" @selected(old('grid_columns', $section->grid_columns ?? 3) == 3)>3 columns</option>
            <option value="4" @selected(old('grid_columns', $section->grid_columns ?? 3) == 4)>4 columns</option>
            <option value="5" @selected(old('grid_columns', $section->grid_columns ?? 3) == 5)>5 columns</option>
            <option value="6" @selected(old('grid_columns', $section->grid_columns ?? 3) == 6)>6 columns</option>
        </select>
        @error('grid_columns')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-4 flex flex-wrap gap-6">
    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $section->is_active ?? true))>
        Active
    </label>
    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="show_view_all" value="1" @checked(old('show_view_all', $section->show_view_all ?? true))>
        Show “View all” link
    </label>
</div>

<div class="mt-6 flex items-center gap-3">
    <button type="submit" class="rounded-lg bg-brand-ink px-4 py-2 text-sm font-medium text-white">Save Section</button>
    <a href="{{ route('admin.home-page.index') }}" class="text-sm text-brand-ink/60 hover:text-brand-ink">Cancel</a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const typeSelect = document.getElementById('type');
        const titleField = document.getElementById('title-field');
        const categoryField = document.getElementById('category-field');
        const subcategoryField = document.getElementById('subcategory-field');
        const categorySelect = document.getElementById('category_id');
        const subcategorySelect = document.getElementById('subcategory_id');
        const titleInput = document.getElementById('title');

        function toggleFields() {
            const type = typeSelect.value;
            const isFlag = type === 'flag';
            const isCategory = type === 'category';
            const isSubcategory = type === 'subcategory';

            if (titleField) titleField.style.display = isFlag ? '' : 'none';
            if (categoryField) categoryField.style.display = isCategory ? '' : 'none';
            if (subcategoryField) subcategoryField.style.display = isSubcategory ? '' : 'none';
            if (titleInput) titleInput.required = isFlag;

            if (categorySelect) {
                categorySelect.disabled = !isCategory;
                categorySelect.name = isCategory ? 'category_id' : '';
            }
            if (subcategorySelect) {
                subcategorySelect.disabled = !isSubcategory;
                subcategorySelect.name = isSubcategory ? 'category_id' : '';
            }
        }

        typeSelect?.addEventListener('change', toggleFields);
        toggleFields();
    });
</script>
