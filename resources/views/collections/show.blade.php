@extends('layouts.app')

@section('title', $title)
@section('meta_description', $title.' products from XPERCIAINC')

@section('content')
<section class="collection-page">
    <div class="container">
        <h1 class="collection-page-title">{{ $title }}</h1>

        <form class="collection-toolbar" method="get" action="{{ route('collections.show', $collectionSlug) }}" data-collection-filters>
            <div class="collection-toolbar-left">
                <span class="collection-toolbar-label">Filter:</span>

                <div class="collection-filter" data-filter-dropdown>
                    <button type="button" class="collection-filter-btn" data-filter-toggle aria-expanded="false">
                        Availability
                        <svg viewBox="0 0 16 16" fill="none" aria-hidden="true">
                            <path d="M3.5 6l4.5 4.5L12.5 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <div class="collection-filter-menu" data-filter-menu hidden>
                        <label class="collection-filter-option">
                            <input type="radio" name="availability" value="" {{ ($filters['availability'] ?? '') === '' ? 'checked' : '' }}>
                            <span>All</span>
                        </label>
                        <label class="collection-filter-option">
                            <input type="radio" name="availability" value="in-stock" {{ ($filters['availability'] ?? '') === 'in-stock' ? 'checked' : '' }}>
                            <span>In stock</span>
                        </label>
                        <label class="collection-filter-option">
                            <input type="radio" name="availability" value="out-of-stock" {{ ($filters['availability'] ?? '') === 'out-of-stock' ? 'checked' : '' }}>
                            <span>Out of stock</span>
                        </label>
                    </div>
                </div>

                <div class="collection-filter" data-filter-dropdown>
                    <button type="button" class="collection-filter-btn" data-filter-toggle aria-expanded="false">
                        Price
                        <svg viewBox="0 0 16 16" fill="none" aria-hidden="true">
                            <path d="M3.5 6l4.5 4.5L12.5 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <div class="collection-filter-menu collection-filter-menu--price" data-filter-menu hidden>
                        <div class="collection-price-fields">
                            <label>
                                <span>Min</span>
                                <input type="number" name="min_price" min="0" step="0.01" value="{{ $filters['min_price'] ?? '' }}" placeholder="0">
                            </label>
                            <label>
                                <span>Max</span>
                                <input type="number" name="max_price" min="0" step="0.01" value="{{ $filters['max_price'] ?? '' }}" placeholder="Any">
                            </label>
                        </div>
                        <button type="submit" class="collection-filter-apply">Apply</button>
                    </div>
                </div>
            </div>

            <div class="collection-toolbar-right">
                <div class="collection-sort">
                    <label for="collection-sort" class="collection-toolbar-label">Sort by:</label>
                    <div class="collection-filter" data-filter-dropdown>
                        <button type="button" class="collection-filter-btn" data-filter-toggle aria-expanded="false">
                            <span data-sort-label>
                                @switch($filters['sort'] ?? 'featured')
                                    @case('price-asc') Price, low to high @break
                                    @case('price-desc') Price, high to low @break
                                    @case('title-asc') Alphabetically, A-Z @break
                                    @case('title-desc') Alphabetically, Z-A @break
                                    @default Featured
                                @endswitch
                            </span>
                            <svg viewBox="0 0 16 16" fill="none" aria-hidden="true">
                                <path d="M3.5 6l4.5 4.5L12.5 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <div class="collection-filter-menu" data-filter-menu hidden>
                            <label class="collection-filter-option">
                                <input type="radio" name="sort" value="featured" {{ ($filters['sort'] ?? 'featured') === 'featured' ? 'checked' : '' }}>
                                <span>Featured</span>
                            </label>
                            <label class="collection-filter-option">
                                <input type="radio" name="sort" value="price-asc" {{ ($filters['sort'] ?? '') === 'price-asc' ? 'checked' : '' }}>
                                <span>Price, low to high</span>
                            </label>
                            <label class="collection-filter-option">
                                <input type="radio" name="sort" value="price-desc" {{ ($filters['sort'] ?? '') === 'price-desc' ? 'checked' : '' }}>
                                <span>Price, high to low</span>
                            </label>
                            <label class="collection-filter-option">
                                <input type="radio" name="sort" value="title-asc" {{ ($filters['sort'] ?? '') === 'title-asc' ? 'checked' : '' }}>
                                <span>Alphabetically, A-Z</span>
                            </label>
                            <label class="collection-filter-option">
                                <input type="radio" name="sort" value="title-desc" {{ ($filters['sort'] ?? '') === 'title-desc' ? 'checked' : '' }}>
                                <span>Alphabetically, Z-A</span>
                            </label>
                        </div>
                    </div>
                </div>

                <p class="collection-count">
                    {{ $productCount }} {{ $productCount === 1 ? 'product' : 'products' }}
                </p>
            </div>
        </form>

        <div class="collection-grid">
            @forelse ($products as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                    <div class="product-card-media">
                        @if ($product->imageUrl())
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <div class="product-card-placeholder" aria-hidden="true"></div>
                        @endif
                    </div>
                    <h2 class="product-card-title">{{ $product->name }}</h2>
                    <p class="product-card-price">{{ $product->formattedPriceFrom() }}</p>
                </a>
            @empty
                <p class="collection-empty">No products found in this collection.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
