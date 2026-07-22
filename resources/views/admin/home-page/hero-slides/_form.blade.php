<div class="grid gap-4 md:grid-cols-2">
    <div>
        <label for="image" class="mb-1 block text-sm font-medium">Image Path *</label>
        <input id="image" name="image" type="text" value="{{ old('image', $slide->image) }}" required
               class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm" placeholder="images/hero-7.png">
        @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="alt_text" class="mb-1 block text-sm font-medium">Alt Text</label>
        <input id="alt_text" name="alt_text" type="text" value="{{ old('alt_text', $slide->alt_text) }}"
               class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
        @error('alt_text')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="sort_order" class="mb-1 block text-sm font-medium">Sort Order</label>
        <input id="sort_order" name="sort_order" type="number" min="0" value="{{ old('sort_order', $slide->sort_order ?? 0) }}"
               class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
        @error('sort_order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div class="flex items-end">
        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $slide->is_active ?? true))>
            Active
        </label>
    </div>
</div>

<div class="mt-6 flex items-center gap-3">
    <button type="submit" class="rounded-lg bg-brand-ink px-4 py-2 text-sm font-medium text-white">Save Slide</button>
    <a href="{{ route('admin.home-page.index') }}" class="text-sm text-brand-ink/60 hover:text-brand-ink">Cancel</a>
</div>
