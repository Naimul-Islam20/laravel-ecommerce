@extends('admin.layouts.app')

@section('title', 'Products')
@section('heading', 'Products')
@section('subheading', 'Manage catalog products')

@section('content')
    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <form method="GET" action="{{ route('admin.products.index') }}" class="flex gap-2">
            <input type="search" name="search" value="{{ $search }}" placeholder="Search products..."
                   class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm sm:w-72">
            <button type="submit" class="rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">Search</button>
        </form>
        <a href="{{ route('admin.products.create') }}" class="inline-flex justify-center rounded-lg bg-brand-ink px-4 py-2 text-sm font-medium text-white">
            Add Product
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-brand-ink/10 bg-white">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-brand-mist/50 text-left text-brand-ink/60">
                    <tr>
                        <th class="px-5 py-3 font-medium">Name</th>
                        <th class="px-5 py-3 font-medium">Category</th>
                        <th class="px-5 py-3 font-medium">Price</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($products as $product)
                        <tr class="border-t border-brand-ink/5">
                            <td class="px-5 py-3">
                                <div class="font-medium">{{ $product->name }}</div>
                                <div class="text-xs text-brand-ink/50">{{ $product->slug }}</div>
                            </td>
                            <td class="px-5 py-3">{{ $product->category?->name ?? '—' }}</td>
                            <td class="px-5 py-3">{{ $product->formattedPriceFrom() }}</td>
                            <td class="px-5 py-3">
                                <span class="rounded-full px-2 py-0.5 text-xs {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-right">
                                <a href="{{ route('admin.products.edit', $product) }}" class="mr-3 text-brand-ink/70 hover:text-brand-ink">Edit</a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-brand-ink/60">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($products->hasPages())
            <div class="border-t border-brand-ink/10 px-5 py-4">
                {{ $products->links() }}
            </div>
        @endif
    </div>
@endsection
