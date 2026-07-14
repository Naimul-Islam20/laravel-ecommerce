@extends('layouts.app')

@section('title', 'Home')

@section('content')
<section class="hero" aria-label="Featured" data-hero-slider>
    <div class="hero-bg">
        <div class="hero-slide is-active" data-slide>
            <img src="{{ asset('images/hero-1.webp') }}" alt="xperciainc eco-friendly packaging" width="1920" height="768">
        </div>
        <div class="hero-slide" data-slide>
            <img src="{{ asset('images/hero-2.webp') }}" alt="xperciainc product collection" width="1920" height="768">
        </div>
    </div>

    <div class="hero-cta">
        <div class="container">
            <a href="{{ route('shop') }}" class="hero-shop-btn">
                Shop Now
            </a>
        </div>
    </div>
</section>

<div class="hero-pagination" data-hero-controls>
    <button type="button" class="hero-ctrl" data-hero-prev aria-label="Previous slide">
        <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
            <path d="M10 3L5 8l5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </button>

    <div class="flex items-center gap-2" data-hero-dots role="tablist" aria-label="Slides">
        <button type="button" class="hero-dot is-active" data-hero-dot="0" aria-label="Go to slide 1"></button>
        <button type="button" class="hero-dot" data-hero-dot="1" aria-label="Go to slide 2"></button>
    </div>

    <div class="hero-pagination-end">
        <button type="button" class="hero-ctrl" data-hero-next aria-label="Next slide">
            <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                <path d="M6 3l5 5-5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        <span class="hero-pagination-divider" aria-hidden="true"></span>

        <button type="button" class="hero-ctrl" data-hero-play aria-label="Pause slideshow" aria-pressed="false">
            <svg class="h-3.5 w-3.5 play-icon" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                <path d="M4 2.5v11l9-5.5-9-5.5z"/>
            </svg>
            <svg class="h-3.5 w-3.5 pause-icon hidden" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true">
                <path d="M4 3h3v10H4V3zm5 0h3v10H9V3z"/>
            </svg>
        </button>
    </div>
</div>

<section id="collections" class="collections-section">
    <div class="container">
        <h2 class="collections-heading">Collections</h2>

        <div class="collections-grid">
            @forelse ($collections ?? [] as $collection)
                <a href="{{ route('collections.show', $collection->slug) }}" class="collection-card">
                    <div class="collection-card-media">
                        @if ($collection->imageUrl())
                            <img src="{{ $collection->imageUrl() }}" alt="{{ $collection->name }}" loading="lazy">
                        @else
                            <div class="collection-card-placeholder" aria-hidden="true"></div>
                        @endif
                    </div>
                    <span class="collection-card-label">
                        {{ $collection->slug === 'food-containers' ? 'Food Container' : $collection->name }}
                        <svg viewBox="0 0 16 16" fill="none" aria-hidden="true">
                            <path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </span>
                </a>
            @empty
                <p class="text-sm text-brand-ink/55">No collections yet.</p>
            @endforelse
        </div>
    </div>
</section>

<section id="best-sellers" class="best-sellers-section">
    <div class="container">
        <h2 class="best-sellers-heading">Best Seller</h2>

        <div class="best-sellers-grid">
            @forelse ($bestSellers ?? [] as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                    <div class="product-card-media">
                        @if ($product->imageUrl())
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <div class="product-card-placeholder" aria-hidden="true"></div>
                        @endif
                    </div>
                    <h3 class="product-card-title">{{ $product->name }}</h3>
                    <p class="product-card-price">{{ $product->formattedPriceFrom() }}</p>
                </a>
            @empty
                <p class="text-sm text-brand-ink/55">No best sellers yet.</p>
            @endforelse
        </div>

        <div class="best-sellers-actions">
            <div class="view-all-wrap">
                <a href="{{ route('collections.show', 'best-sellers') }}" class="view-all-btn">View all</a>
            </div>
        </div>
    </div>
</section>

<section id="top-selling" class="best-sellers-section">
    <div class="container">
        <h2 class="best-sellers-heading">Top Selling Product</h2>

        <div class="best-sellers-grid">
            @forelse ($topSelling ?? [] as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                    <div class="product-card-media">
                        @if ($product->imageUrl())
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <div class="product-card-placeholder" aria-hidden="true"></div>
                        @endif
                    </div>
                    <h3 class="product-card-title">{{ $product->name }}</h3>
                    <p class="product-card-price">{{ $product->formattedPriceFrom() }}</p>
                </a>
            @empty
                <p class="text-sm text-brand-ink/55">No top selling products yet.</p>
            @endforelse
        </div>

        <div class="best-sellers-actions">
            <div class="view-all-wrap">
                <a href="{{ route('collections.show', 'top-selling') }}" class="view-all-btn">View all</a>
            </div>
        </div>
    </div>
</section>

<section id="hinged-box" class="best-sellers-section">
    <div class="container">
        <h2 class="best-sellers-heading">Hinged Box</h2>

        <div class="best-sellers-grid">
            @forelse ($hingedBox ?? [] as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                    <div class="product-card-media">
                        @if ($product->imageUrl())
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <div class="product-card-placeholder" aria-hidden="true"></div>
                        @endif
                    </div>
                    <h3 class="product-card-title">{{ $product->name }}</h3>
                    <p class="product-card-price">{{ $product->formattedPriceFrom() }}</p>
                </a>
            @empty
                <p class="text-sm text-brand-ink/55">No hinged box products yet.</p>
            @endforelse
        </div>

        <div class="best-sellers-actions">
            <div class="view-all-wrap">
                <a href="{{ route('collections.show', 'hinged-box') }}" class="view-all-btn">View all</a>
            </div>
        </div>
    </div>
</section>

<section id="trending" class="best-sellers-section">
    <div class="container">
        <h2 class="best-sellers-heading">Trending Product</h2>

        <div class="best-sellers-grid">
            @forelse ($trending ?? [] as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                    <div class="product-card-media">
                        @if ($product->imageUrl())
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <div class="product-card-placeholder" aria-hidden="true"></div>
                        @endif
                    </div>
                    <h3 class="product-card-title">{{ $product->name }}</h3>
                    <p class="product-card-price">{{ $product->formattedPriceFrom() }}</p>
                </a>
            @empty
                <p class="text-sm text-brand-ink/55">No trending products yet.</p>
            @endforelse
        </div>

        <div class="best-sellers-actions">
            <div class="view-all-wrap">
                <a href="{{ route('collections.show', 'trending') }}" class="view-all-btn">View all</a>
            </div>
        </div>
    </div>
</section>

<section id="meal-trays" class="best-sellers-section">
    <div class="container">
        <h2 class="best-sellers-heading">Meal Trays</h2>

        <div class="best-sellers-grid">
            @forelse ($mealTrays ?? [] as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                    <div class="product-card-media">
                        @if ($product->imageUrl())
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <div class="product-card-placeholder" aria-hidden="true"></div>
                        @endif
                    </div>
                    <h3 class="product-card-title">{{ $product->name }}</h3>
                    <p class="product-card-price">{{ $product->formattedPriceFrom() }}</p>
                </a>
            @empty
                <p class="text-sm text-brand-ink/55">No meal trays yet.</p>
            @endforelse
        </div>

        <div class="best-sellers-actions">
            <div class="view-all-wrap">
                <a href="{{ route('collections.show', 'meal-trays') }}" class="view-all-btn">View all</a>
            </div>
        </div>
    </div>
</section>

<section id="round-containers" class="best-sellers-section">
    <div class="container">
        <h2 class="best-sellers-heading">Round Containers</h2>

        <div class="best-sellers-grid">
            @forelse ($roundContainers ?? [] as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                    <div class="product-card-media">
                        @if ($product->imageUrl())
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <div class="product-card-placeholder" aria-hidden="true"></div>
                        @endif
                    </div>
                    <h3 class="product-card-title">{{ $product->name }}</h3>
                    <p class="product-card-price">{{ $product->formattedPriceFrom() }}</p>
                </a>
            @empty
                <p class="text-sm text-brand-ink/55">No round containers yet.</p>
            @endforelse
        </div>

        <div class="best-sellers-actions">
            <div class="view-all-wrap">
                <a href="{{ route('collections.show', 'round-containers') }}" class="view-all-btn">View all</a>
            </div>
        </div>
    </div>
</section>

<section id="rectangular-container" class="best-sellers-section">
    <div class="container">
        <h2 class="best-sellers-heading">Rectangular Container</h2>

        <div class="best-sellers-grid">
            @forelse ($rectangularContainers ?? [] as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                    <div class="product-card-media">
                        @if ($product->imageUrl())
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <div class="product-card-placeholder" aria-hidden="true"></div>
                        @endif
                    </div>
                    <h3 class="product-card-title">{{ $product->name }}</h3>
                    <p class="product-card-price">{{ $product->formattedPriceFrom() }}</p>
                </a>
            @empty
                <p class="text-sm text-brand-ink/55">No rectangular containers yet.</p>
            @endforelse
        </div>

        <div class="best-sellers-actions">
            <div class="view-all-wrap">
                <a href="{{ route('collections.show', 'rectangular-containers') }}" class="view-all-btn">View all</a>
            </div>
        </div>
    </div>
</section>

<section id="cornstarch-product" class="best-sellers-section">
    <div class="container">
        <h2 class="best-sellers-heading">Cornstarch Product</h2>

        <div class="best-sellers-grid best-sellers-grid--4">
            @forelse ($cornstarchProducts ?? [] as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                    <div class="product-card-media">
                        @if ($product->imageUrl())
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <div class="product-card-placeholder" aria-hidden="true"></div>
                        @endif
                    </div>
                    <h3 class="product-card-title">{{ $product->name }}</h3>
                    <p class="product-card-price">{{ $product->formattedPriceFrom() }}</p>
                </a>
            @empty
                <p class="text-sm text-brand-ink/55">No cornstarch products yet.</p>
            @endforelse
        </div>

        <div class="best-sellers-actions">
            <div class="view-all-wrap">
                <a href="{{ route('collections.show', 'cornstarch-product') }}" class="view-all-btn">View all</a>
            </div>
        </div>
    </div>
</section>

<section id="aluminium-foil-container" class="best-sellers-section">
    <div class="container">
        <h2 class="best-sellers-heading">Aluminium Foil Container</h2>

        <div class="best-sellers-grid best-sellers-grid--4">
            @forelse ($aluminiumFoilContainers ?? [] as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                    <div class="product-card-media">
                        @if ($product->imageUrl())
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <div class="product-card-placeholder" aria-hidden="true"></div>
                        @endif
                    </div>
                    <h3 class="product-card-title">{{ $product->name }}</h3>
                    <p class="product-card-price">{{ $product->formattedPriceFrom() }}</p>
                </a>
            @empty
                <p class="text-sm text-brand-ink/55">No aluminium foil containers yet.</p>
            @endforelse
        </div>

        <div class="best-sellers-actions">
            <div class="view-all-wrap">
                <a href="{{ route('collections.show', 'aluminium-containers') }}" class="view-all-btn">View all</a>
            </div>
        </div>
    </div>
</section>

<section id="bagasse-tableware" class="best-sellers-section">
    <div class="container">
        <h2 class="best-sellers-heading">Bagasse Tableware</h2>

        <div class="best-sellers-grid">
            @forelse ($bagasseTableware ?? [] as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                    <div class="product-card-media">
                        @if ($product->imageUrl())
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <div class="product-card-placeholder" aria-hidden="true"></div>
                        @endif
                    </div>
                    <h3 class="product-card-title">{{ $product->name }}</h3>
                    <p class="product-card-price">{{ $product->formattedPriceFrom() }}</p>
                </a>
            @empty
                <p class="text-sm text-brand-ink/55">No bagasse tableware yet.</p>
            @endforelse
        </div>

        <div class="best-sellers-actions">
            <div class="view-all-wrap">
                <a href="{{ route('collections.show', 'bagasse-products') }}" class="view-all-btn">View all</a>
            </div>
        </div>
    </div>
</section>

<section id="biodegradable-products" class="best-sellers-section">
    <div class="container">
        <h2 class="best-sellers-heading">Biodegradable Products</h2>

        <div class="best-sellers-grid">
            @forelse ($biodegradableProducts ?? [] as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                    <div class="product-card-media">
                        @if ($product->imageUrl())
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <div class="product-card-placeholder" aria-hidden="true"></div>
                        @endif
                    </div>
                    <h3 class="product-card-title">{{ $product->name }}</h3>
                    <p class="product-card-price">{{ $product->formattedPriceFrom() }}</p>
                </a>
            @empty
                <p class="text-sm text-brand-ink/55">No biodegradable products yet.</p>
            @endforelse
        </div>

        <div class="best-sellers-actions">
            <div class="view-all-wrap">
                <a href="{{ route('collections.show', 'biodegradable-products') }}" class="view-all-btn">View all</a>
            </div>
        </div>
    </div>
</section>

<section id="bagasse-takeaway-container" class="best-sellers-section">
    <div class="container">
        <h2 class="best-sellers-heading">Bagasse Takeaway Container</h2>

        <div class="best-sellers-grid">
            @forelse ($bagasseTakeawayContainers ?? [] as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                    <div class="product-card-media">
                        @if ($product->imageUrl())
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <div class="product-card-placeholder" aria-hidden="true"></div>
                        @endif
                    </div>
                    <h3 class="product-card-title">{{ $product->name }}</h3>
                    <p class="product-card-price">{{ $product->formattedPriceFrom() }}</p>
                </a>
            @empty
                <p class="text-sm text-brand-ink/55">No bagasse takeaway containers yet.</p>
            @endforelse
        </div>

        <div class="best-sellers-actions">
            <div class="view-all-wrap">
                <a href="{{ route('collections.show', 'bagasse-takeaway-container') }}" class="view-all-btn">View all</a>
            </div>
        </div>
    </div>
</section>

<section id="paper-products" class="best-sellers-section">
    <div class="container">
        <h2 class="best-sellers-heading">Paper Products</h2>

        <div class="best-sellers-grid">
            @forelse ($paperProducts ?? [] as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                    <div class="product-card-media">
                        @if ($product->imageUrl())
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <div class="product-card-placeholder" aria-hidden="true"></div>
                        @endif
                    </div>
                    <h3 class="product-card-title">{{ $product->name }}</h3>
                    <p class="product-card-price">{{ $product->formattedPriceFrom() }}</p>
                </a>
            @empty
                <p class="text-sm text-brand-ink/55">No paper products yet.</p>
            @endforelse
        </div>

        <div class="best-sellers-actions">
            <div class="view-all-wrap">
                <a href="{{ route('collections.show', 'paper-products') }}" class="view-all-btn">View all</a>
            </div>
        </div>
    </div>
</section>

<section id="new-arrivals" class="best-sellers-section">
    <div class="container">
        <h2 class="best-sellers-heading">New Arrivals</h2>

        <div class="best-sellers-grid">
            @forelse ($newArrivals ?? [] as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                    <div class="product-card-media">
                        @if ($product->imageUrl())
                            <img src="{{ $product->imageUrl() }}" alt="{{ $product->name }}" loading="lazy">
                        @else
                            <div class="product-card-placeholder" aria-hidden="true"></div>
                        @endif
                    </div>
                    <h3 class="product-card-title">{{ $product->name }}</h3>
                    <p class="product-card-price">{{ $product->formattedPriceFrom() }}</p>
                </a>
            @empty
                <p class="text-sm text-brand-ink/55">No new arrivals yet.</p>
            @endforelse
        </div>

        <div class="best-sellers-actions">
            <div class="view-all-wrap">
                <a href="{{ route('collections.show', 'new-arrivals') }}" class="view-all-btn">View all</a>
            </div>
        </div>
    </div>
</section>

<div id="shop" class="sr-only" aria-hidden="true"></div>
<div id="bulk" class="sr-only" aria-hidden="true"></div>
@endsection
