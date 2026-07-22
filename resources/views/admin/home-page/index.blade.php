@extends('admin.layouts.app')

@section('title', 'Home Page')
@section('heading', 'Home Page')
@section('subheading', 'Manage hero, slides, and product sections')

@section('content')
    <div class="space-y-6">
        <section class="rounded-xl border border-brand-ink/10 bg-white p-5">
            <h2 class="font-display text-lg font-semibold">Hero Settings</h2>
            <p class="mt-1 text-sm text-brand-ink/60">Control the main hero call-to-action button.</p>

            <form method="POST" action="{{ route('admin.home-page.settings.update') }}" class="mt-4 grid gap-4 md:grid-cols-2">
                @csrf
                @method('PUT')
                <div>
                    <label for="hero_cta_text" class="mb-1 block text-sm font-medium">Button Text</label>
                    <input id="hero_cta_text" name="hero_cta_text" type="text"
                           value="{{ old('hero_cta_text', $settings->hero_cta_text) }}" required
                           class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
                    @error('hero_cta_text')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="hero_cta_url" class="mb-1 block text-sm font-medium">Button URL</label>
                    <input id="hero_cta_url" name="hero_cta_url" type="text"
                           value="{{ old('hero_cta_url', $settings->hero_cta_url) }}" required
                           class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm" placeholder="/shop">
                    @error('hero_cta_url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="md:col-span-2">
                    <button type="submit" class="rounded-lg bg-brand-ink px-4 py-2 text-sm font-medium text-white">Save Hero Settings</button>
                </div>
            </form>
        </section>

        <section class="rounded-xl border border-brand-ink/10 bg-white p-5">
            <div class="mb-4 flex items-center justify-between gap-3">
                <div>
                    <h2 class="font-display text-lg font-semibold">Hero Slides</h2>
                    <p class="mt-1 text-sm text-brand-ink/60">Images shown in the homepage hero slider.</p>
                </div>
                <a href="{{ route('admin.home-hero-slides.create') }}" class="rounded-lg bg-brand-ink px-4 py-2 text-sm font-medium text-white">Add Slide</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-brand-mist/50 text-left text-brand-ink/60">
                        <tr>
                            <th class="px-4 py-3 font-medium">Preview</th>
                            <th class="px-4 py-3 font-medium">Image Path</th>
                            <th class="px-4 py-3 font-medium">Order</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                            <th class="px-4 py-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($heroSlides as $slide)
                            <tr class="border-t border-brand-ink/5">
                                <td class="px-4 py-3">
                                    <img src="{{ $slide->imageUrl() }}" alt="" class="h-12 w-24 rounded object-cover">
                                </td>
                                <td class="px-4 py-3">{{ $slide->image }}</td>
                                <td class="px-4 py-3">{{ $slide->sort_order }}</td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full px-2 py-0.5 text-xs {{ $slide->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $slide->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.home-hero-slides.edit', $slide) }}" class="mr-3 hover:underline">Edit</a>
                                    <form action="{{ route('admin.home-hero-slides.destroy', $slide) }}" method="POST" class="inline" onsubmit="return confirm('Delete this slide?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-8 text-center text-brand-ink/60">No hero slides yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="rounded-xl border border-brand-ink/10 bg-white p-5">
            <div class="mb-4 flex items-center justify-between gap-3">
                <div>
                    <h2 class="font-display text-lg font-semibold">Product Sections</h2>
                    <p class="mt-1 text-sm text-brand-ink/60">
                        Add category-based sections (newest products first) or flag-based sections (from product Home Section Flags).
                    </p>
                </div>
                <a href="{{ route('admin.home-sections.create') }}" class="rounded-lg bg-brand-ink px-4 py-2 text-sm font-medium text-white">Add Section</a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-brand-mist/50 text-left text-brand-ink/60">
                        <tr>
                            <th class="px-4 py-3 font-medium">Title</th>
                            <th class="px-4 py-3 font-medium">Type</th>
                            <th class="px-4 py-3 font-medium">Source</th>
                            <th class="px-4 py-3 font-medium">Limit</th>
                            <th class="px-4 py-3 font-medium">Order</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                            <th class="px-4 py-3 font-medium text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sections as $section)
                            <tr class="border-t border-brand-ink/5">
                                <td class="px-4 py-3">
                                    <div class="font-medium">{{ $section->title }}</div>
                                    <div class="text-xs text-brand-ink/50">{{ $section->slug }}</div>
                                </td>
                                <td class="px-4 py-3 capitalize">{{ $section->type }}</td>
                                <td class="px-4 py-3">
                                    @if ($section->isCategoryType())
                                        Category: {{ $section->category?->name ?? '—' }}
                                    @elseif ($section->isSubcategoryType())
                                        SubCategory: {{ $section->category?->parent?->name ? $section->category->parent->name.' › ' : '' }}{{ $section->category?->name ?? '—' }}
                                    @else
                                        Flag (product checkboxes)
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ $section->product_limit }}</td>
                                <td class="px-4 py-3">{{ $section->sort_order }}</td>
                                <td class="px-4 py-3">
                                    <span class="rounded-full px-2 py-0.5 text-xs {{ $section->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $section->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <a href="{{ route('admin.home-sections.edit', $section) }}" class="mr-3 hover:underline">Edit</a>
                                    <form action="{{ route('admin.home-sections.destroy', $section) }}" method="POST" class="inline" onsubmit="return confirm('Delete this section?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-4 py-8 text-center text-brand-ink/60">No sections yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <p class="text-sm text-brand-ink/60">
            Collections section is still managed from Categories using the “Show on Home” option.
        </p>
    </div>
@endsection
