@extends('admin.layouts.app')

@section('title', 'Categories')
@section('heading', 'Categories')
@section('subheading', 'Top-level categories for menu and collections')

@section('content')
    <div class="mb-4 flex justify-end">
        <a href="{{ route('admin.categories.create') }}" class="inline-flex rounded-lg bg-brand-ink px-4 py-2 text-sm font-medium text-white">
            Add Category
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-brand-ink/10 bg-white">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-brand-mist/50 text-left text-brand-ink/60">
                    <tr>
                        <th class="px-5 py-3 font-medium">Name</th>
                        <th class="px-5 py-3 font-medium">Subcategories</th>
                        <th class="px-5 py-3 font-medium">Products</th>
                        <th class="px-5 py-3 font-medium">Home</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr class="border-t border-brand-ink/5">
                            <td class="px-5 py-3">
                                <div class="font-medium">{{ $category->name }}</div>
                                <div class="text-xs text-brand-ink/50">{{ $category->slug }}</div>
                            </td>
                            <td class="px-5 py-3">{{ $category->children_count }}</td>
                            <td class="px-5 py-3">{{ $category->products_count }}</td>
                            <td class="px-5 py-3">
                                @if ($category->show_on_home)
                                    <span class="rounded-full bg-green-100 px-2 py-0.5 text-xs text-green-800">Yes</span>
                                @else
                                    <span class="text-brand-ink/40">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-3">
                                <span class="rounded-full px-2 py-0.5 text-xs {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="mr-3 text-brand-ink/70 hover:text-brand-ink">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Delete this category?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-8 text-center text-brand-ink/60">No categories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($categories->hasPages())
            <div class="border-t border-brand-ink/10 px-5 py-4">
                {{ $categories->links() }}
            </div>
        @endif
    </div>
@endsection
