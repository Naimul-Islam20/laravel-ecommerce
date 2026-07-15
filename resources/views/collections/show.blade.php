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

                <div class="collection-filter" data-filter-dropdown data-availability-filter>
                    <button type="button" class="collection-filter-btn" data-filter-toggle aria-expanded="false">
                        Availability
                        <svg viewBox="0 0 16 16" fill="none" aria-hidden="true">
                            <path d="M3.5 6l4.5 4.5L12.5 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <div class="collection-filter-menu collection-filter-menu--panel" data-filter-menu hidden>
                        <div class="collection-filter-panel-head">
                            <p class="collection-filter-panel-title" data-availability-selected>0 selected</p>
                        </div>

                        <div class="collection-filter-panel-options">
                            <label class="collection-filter-option">
                                <input type="checkbox" name="availability[]" value="in-stock" data-availability-option {{ in_array('in-stock', (array) ($filters['availability'] ?? []), true) ? 'checked' : '' }}>
                                <span>In stock</span>
                            </label>
                            <label class="collection-filter-option">
                                <input type="checkbox" name="availability[]" value="out-of-stock" data-availability-option {{ in_array('out-of-stock', (array) ($filters['availability'] ?? []), true) ? 'checked' : '' }}>
                                <span>Out of stock</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="collection-filter" data-filter-dropdown data-price-filter>
                    <button type="button" class="collection-filter-btn" data-filter-toggle aria-expanded="false">
                        Price
                        <svg viewBox="0 0 16 16" fill="none" aria-hidden="true">
                            <path d="M3.5 6l4.5 4.5L12.5 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <div class="collection-filter-menu collection-filter-menu--panel collection-filter-menu--price" data-filter-menu hidden>
                        <div class="collection-filter-panel-head">
                            <p class="collection-filter-panel-title">
                                The highest price is Rs. {{ number_format($highestPrice ?? 0, 2) }}
                            </p>
                        </div>

                        <div class="collection-price-fields">
                            <label class="collection-price-field">
                                <span class="collection-price-row">
                                    <span class="collection-price-currency">₹</span>
                                    <span class="collection-price-input-wrap">
                                        <input
                                            type="text"
                                            name="min_price"
                                            inputmode="decimal"
                                            autocomplete="off"
                                            value=""
                                            data-price-min
                                            placeholder=" ">
                                        <span class="collection-price-field-label">From</span>
                                    </span>
                                </span>
                            </label>
                            <label class="collection-price-field">
                                <span class="collection-price-row">
                                    <span class="collection-price-currency">₹</span>
                                    <span class="collection-price-input-wrap">
                                        <input
                                            type="text"
                                            name="max_price"
                                            inputmode="decimal"
                                            autocomplete="off"
                                            value=""
                                            data-price-max
                                            placeholder=" ">
                                        <span class="collection-price-field-label">To</span>
                                    </span>
                                </span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="collection-toolbar-right">
                <div class="collection-sort">
                    <label class="collection-toolbar-label">Sort by:</label>
                    <div class="collection-filter" data-filter-dropdown data-sort-filter>
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
                                <path d="M3.5 6l4.5 4.5L12.5 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>
                        <div class="collection-filter-menu collection-filter-menu--panel collection-filter-menu--sort" data-filter-menu hidden>
                            <div class="collection-filter-panel-head">
                                <p class="collection-filter-panel-title" data-sort-selected>
                                    @switch($filters['sort'] ?? 'featured')
                                    @case('price-asc') Price, low to high @break
                                    @case('price-desc') Price, high to low @break
                                    @case('title-asc') Alphabetically, A-Z @break
                                    @case('title-desc') Alphabetically, Z-A @break
                                    @default Featured
                                    @endswitch
                                </p>
                            </div>

                            <div class="collection-filter-panel-options">
                                <label class="collection-filter-option">
                                    <input type="radio" name="sort" value="featured" data-sort-option {{ ($filters['sort'] ?? 'featured') === 'featured' ? 'checked' : '' }}>
                                    <span>Featured</span>
                                </label>
                                <label class="collection-filter-option">
                                    <input type="radio" name="sort" value="price-asc" data-sort-option {{ ($filters['sort'] ?? '') === 'price-asc' ? 'checked' : '' }}>
                                    <span>Price, low to high</span>
                                </label>
                                <label class="collection-filter-option">
                                    <input type="radio" name="sort" value="price-desc" data-sort-option {{ ($filters['sort'] ?? '') === 'price-desc' ? 'checked' : '' }}>
                                    <span>Price, high to low</span>
                                </label>
                                <label class="collection-filter-option">
                                    <input type="radio" name="sort" value="title-asc" data-sort-option {{ ($filters['sort'] ?? '') === 'title-asc' ? 'checked' : '' }}>
                                    <span>Alphabetically, A-Z</span>
                                </label>
                                <label class="collection-filter-option">
                                    <input type="radio" name="sort" value="title-desc" data-sort-option {{ ($filters['sort'] ?? '') === 'title-desc' ? 'checked' : '' }}>
                                    <span>Alphabetically, Z-A</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <p class="collection-count" data-collection-count-wrap>
                    <span class="collection-count-spinner" data-collection-count-spinner hidden aria-hidden="true"></span>
                    <span data-collection-count>
                        {{ $productCount }} {{ $productCount === 1 ? 'product' : 'products' }}
                    </span>
                </p>
            </div>
        </form>

        <div class="collection-grid" data-collection-grid>
            @forelse ($products as $product)
            <a
                href="{{ route('products.show', $product->slug) }}"
                class="product-card"
                data-product-card
                data-price="{{ (float) $product->price_from }}"
                data-availability="{{ $product->is_active ? 'in-stock' : 'out-of-stock' }}">
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
            <p class="collection-empty" data-collection-empty>No products found in this collection.</p>
            @endforelse
            <p class="collection-empty" data-collection-empty-filtered hidden>No products found matching your filters.</p>
        </div>
    </div>
</section>
@endsection