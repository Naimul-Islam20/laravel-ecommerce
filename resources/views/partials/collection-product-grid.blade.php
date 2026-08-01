<div class="collection-grid" data-collection-grid>
    @forelse ($products as $product)
        <a href="{{ route('products.show', $product->slug) }}"
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
        <p class="collection-empty" data-collection-empty>{{ $emptyMessage }}</p>
    @endforelse
    <p class="collection-empty" data-collection-empty-filtered hidden>No products found matching your filters.</p>
</div>
