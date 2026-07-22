@extends('admin.layouts.app')

@section('title', 'Subcategories')
@section('heading', 'Subcategories')
@section('subheading', 'Child categories under a parent category')

@section('content')
    <div class="mb-4 flex justify-end">
        <a href="{{ route('admin.subcategories.create') }}" class="inline-flex rounded-lg bg-brand-ink px-4 py-2 text-sm font-medium text-white">
            Add Subcategory
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-brand-ink/10 bg-white">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-brand-mist/50 text-left text-brand-ink/60">
                    <tr>
                        <th class="px-5 py-3 font-medium">Name</th>
                        <th class="px-5 py-3 font-medium">Parent Category</th>
                        <th class="px-5 py-3 font-medium">Products</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($subcategories as $subcategory)
                        <tr class="border-t border-brand-ink/5">
                            <td class="px-5 py-3">
                                <div class="font-medium">{{ $subcategory->name }}</div>
                                <div class="text-xs text-brand-ink/50">{{ $subcategory->slug }}</div>
                            </td>
                            <td class="px-5 py-3">{{ $subcategory->parent?->name ?? '—' }}</td>
                            <td class="px-5 py-3">{{ $subcategory->products_count }}</td>
                            <td class="px-5 py-3">
                                <span class="rounded-full px-2 py-0.5 text-xs {{ $subcategory->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $subcategory->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <a href="{{ route('admin.subcategories.edit', $subcategory) }}" class="mr-3 text-brand-ink/70 hover:text-brand-ink">Edit</a>
                                <form action="{{ route('admin.subcategories.destroy', $subcategory) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Delete this subcategory?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-brand-ink/60">No subcategories found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($subcategories->hasPages())
            <div class="border-t border-brand-ink/10 px-5 py-4">
                {{ $subcategories->links() }}
            </div>
        @endif
    </div>
@endsection
