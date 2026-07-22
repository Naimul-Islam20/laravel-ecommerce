@extends('admin.layouts.app')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')
@section('subheading', 'Overview of your storefront data')

@section('content')
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-xl border border-brand-ink/10 bg-white p-5">
            <p class="text-sm text-brand-ink/60">Total Products</p>
            <p class="mt-2 font-display text-3xl font-semibold">{{ $totalProducts }}</p>
            <p class="mt-1 text-xs text-brand-ink/50">{{ $activeProducts }} active</p>
        </div>
        <div class="rounded-xl border border-brand-ink/10 bg-white p-5">
            <p class="text-sm text-brand-ink/60">Total Categories</p>
            <p class="mt-2 font-display text-3xl font-semibold">{{ $totalCategories }}</p>
            <p class="mt-1 text-xs text-brand-ink/50">{{ $activeCategories }} active</p>
        </div>
        <div class="rounded-xl border border-brand-ink/10 bg-white p-5">
            <p class="text-sm text-brand-ink/60">Active Admins</p>
            <p class="mt-2 font-display text-3xl font-semibold">{{ $adminCount }}</p>
        </div>
        <div class="rounded-xl border border-brand-ink/10 bg-white p-5">
            <p class="text-sm text-brand-ink/60">Quick Actions</p>
            <div class="mt-3 flex flex-wrap gap-2">
                <a href="{{ route('admin.products.create') }}" class="rounded-lg bg-brand-ink px-3 py-1.5 text-xs font-medium text-white">Add Product</a>
                <a href="{{ route('admin.categories.create') }}" class="rounded-lg border border-brand-ink/15 px-3 py-1.5 text-xs font-medium">Add Category</a>
            </div>
        </div>
    </div>

    <div class="mt-6 rounded-xl border border-brand-ink/10 bg-white">
        <div class="border-b border-brand-ink/10 px-5 py-4">
            <h2 class="font-display text-lg font-semibold">Recent Products</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-brand-mist/50 text-left text-brand-ink/60">
                    <tr>
                        <th class="px-5 py-3 font-medium">Name</th>
                        <th class="px-5 py-3 font-medium">Category</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium">Updated</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentProducts as $product)
                        <tr class="border-t border-brand-ink/5">
                            <td class="px-5 py-3">
                                <a href="{{ route('admin.products.edit', $product) }}" class="font-medium hover:underline">
                                    {{ $product->name }}
                                </a>
                            </td>
                            <td class="px-5 py-3">{{ $product->category?->name ?? '—' }}</td>
                            <td class="px-5 py-3">
                                <span class="rounded-full px-2 py-0.5 text-xs {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-brand-ink/60">{{ $product->updated_at?->diffForHumans() }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-brand-ink/60">No products yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
