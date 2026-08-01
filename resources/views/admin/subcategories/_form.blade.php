<div class="grid gap-4 md:grid-cols-2">
    <div>
        <label for="name" class="mb-1 block text-sm font-medium">Name *</label>
        <input id="name" name="name" type="text" value="{{ old('name', $subcategory->name) }}" required
               class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="slug" class="mb-1 block text-sm font-medium">Slug</label>
        <input id="slug" name="slug" type="text" value="{{ old('slug', $subcategory->slug) }}"
               class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm" placeholder="Auto-generated if empty">
        @error('slug')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="parent_id" class="mb-1 block text-sm font-medium">Parent Category *</label>
        <select id="parent_id" name="parent_id" required class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
            <option value="">Select parent category</option>
            @foreach ($parents as $parent)
                <option value="{{ $parent->id }}" @selected(old('parent_id', $subcategory->parent_id) == $parent->id)>
                    {{ $parent->name }}
                </option>
            @endforeach
        </select>
        @error('parent_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        @include('admin.partials.image-upload', [
            'name' => 'image',
            'label' => 'Image',
            'url' => $subcategory->image ? $subcategory->imageUrl() : null,
        ])
    </div>
    <div>
        <label for="sort_order" class="mb-1 block text-sm font-medium">Sort Order</label>
        <input id="sort_order" name="sort_order" type="number" min="0"
               value="{{ old('sort_order', $subcategory->sort_order ?? 0) }}"
               class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
        @error('sort_order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="is_active" class="mb-1 block text-sm font-medium">Status *</label>
        @php
            $statusValue = (int) old('is_active', ($subcategory->is_active ?? true) ? 1 : 0);
        @endphp
        <select id="is_active" name="is_active" required class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
            <option value="1" @selected($statusValue === 1)>Active</option>
            <option value="0" @selected($statusValue === 0)>Inactive</option>
        </select>
        @error('is_active')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-6 flex items-center gap-3">
    <button type="submit" class="rounded-lg bg-brand-ink px-4 py-2 text-sm font-medium text-white hover:bg-brand-ink/90">
        Save Subcategory
    </button>
    <a href="{{ route('admin.subcategories.index') }}" class="text-sm text-brand-ink/60 hover:text-brand-ink">Cancel</a>
</div>
