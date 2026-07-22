@php
    $products = $section->products();
    $viewAllHref = $section->viewAllHref();
@endphp

<section id="{{ $section->slug }}" class="best-sellers-section">
    <div class="container">
        <h2 class="best-sellers-heading">{{ $section->title }}</h2>

        <div class="{{ $section->gridClass() }}">
            @forelse ($products as $product)
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
                <p class="text-sm text-brand-ink/55">No products in this section yet.</p>
            @endforelse
        </div>

        @if ($viewAllHref)
            <div class="best-sellers-actions">
                <div class="view-all-wrap">
                    <a href="{{ $viewAllHref }}" class="view-all-btn">View all</a>
                </div>
            </div>
        @endif
    </div>
</section>
