<div class="grid gap-4 md:grid-cols-2">
    <div>
        <label for="name" class="mb-1 block text-sm font-medium">Name *</label>
        <input id="name" name="name" type="text" value="{{ old('name', $category->name) }}" required
               class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="slug" class="mb-1 block text-sm font-medium">Slug</label>
        <input id="slug" name="slug" type="text" value="{{ old('slug', $category->slug) }}"
               class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm" placeholder="Auto-generated if empty">
        @error('slug')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="image" class="mb-1 block text-sm font-medium">Image Path</label>
        <input id="image" name="image" type="text" value="{{ old('image', $category->image) }}"
               class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm" placeholder="images/category-1.webp">
        @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="menu_column" class="mb-1 block text-sm font-medium">Menu Column</label>
        <input id="menu_column" name="menu_column" type="number" min="1" max="10"
               value="{{ old('menu_column', $category->menu_column) }}"
               class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
        @error('menu_column')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="menu_row" class="mb-1 block text-sm font-medium">Menu Row</label>
        <input id="menu_row" name="menu_row" type="number" min="0"
               value="{{ old('menu_row', $category->menu_row ?? 0) }}"
               class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
        @error('menu_row')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="sort_order" class="mb-1 block text-sm font-medium">Sort Order</label>
        <input id="sort_order" name="sort_order" type="number" min="0"
               value="{{ old('sort_order', $category->sort_order ?? 0) }}"
               class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
        @error('sort_order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="home_sort_order" class="mb-1 block text-sm font-medium">Home Sort Order</label>
        <input id="home_sort_order" name="home_sort_order" type="number" min="0"
               value="{{ old('home_sort_order', $category->home_sort_order ?? 0) }}"
               class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
        @error('home_sort_order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-4 flex flex-wrap gap-6">
    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $category->is_active ?? true))>
        Active
    </label>
    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="show_on_home" value="1" @checked(old('show_on_home', $category->show_on_home ?? false))>
        Show on Home (Collections)
    </label>
</div>

<div class="mt-6 flex items-center gap-3">
    <button type="submit" class="rounded-lg bg-brand-ink px-4 py-2 text-sm font-medium text-white hover:bg-brand-ink/90">
        Save Category
    </button>
    <a href="{{ route('admin.categories.index') }}" class="text-sm text-brand-ink/60 hover:text-brand-ink">Cancel</a>
</div>
