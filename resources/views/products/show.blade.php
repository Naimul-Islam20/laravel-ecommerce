@extends('layouts.app')

@section('title', $product->name)
@section('meta_description', $product->defaultShortDescription())

@section('content')
@php
    $gallery = $product->galleryUrls();
    $packs = $product->packOptions();
    $firstPack = $packs[0] ?? ['pcs' => 25, 'unit_price' => (float) $product->price_from / 25];
    $initialTotal = round($firstPack['pcs'] * $firstPack['unit_price'], 2);
@endphp

<section class="product-detail" data-product-detail>
    <div class="container">
        <div class="product-detail-grid">
            <div class="product-gallery">
                <div class="product-gallery-main">
                    <button type="button" class="product-zoom-btn" aria-label="Zoom image" data-product-zoom>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                            <circle cx="11" cy="11" r="6.5"/>
                            <path d="M16.5 16.5L21 21" stroke-linecap="round"/>
                            <path d="M11 8.5v5M8.5 11h5" stroke-linecap="round"/>
                        </svg>
                    </button>

                    @if (count($gallery))
                        <img
                            src="{{ $gallery[0] }}"
                            alt="{{ $product->name }}"
                            data-product-main-image
                        >
                    @else
                        <div class="product-gallery-placeholder" data-product-main-image aria-hidden="true"></div>
                    @endif
                </div>

                @if (count($gallery) > 1)
                    <div class="product-thumbs" role="list">
                        @foreach ($gallery as $index => $url)
                            <button
                                type="button"
                                class="product-thumb {{ $index === 0 ? 'is-active' : '' }}"
                                data-product-thumb
                                data-image="{{ $url }}"
                                aria-label="View image {{ $index + 1 }}"
                            >
                                <img src="{{ $url }}" alt="" loading="lazy">
                            </button>
                        @endforeach
                    </div>
                @elseif (! count($gallery))
                    <div class="product-thumbs" role="list">
                        <button type="button" class="product-thumb is-active" aria-hidden="true">
                            <div class="product-gallery-placeholder"></div>
                        </button>
                        <button type="button" class="product-thumb" aria-hidden="true">
                            <div class="product-gallery-placeholder"></div>
                        </button>
                    </div>
                @endif
            </div>

            <div class="product-info">
                <p class="product-brand">{{ $product->brand ?: 'XPERCIAINC' }}</p>
                <h1 class="product-title">{{ $product->name }}</h1>
                <p class="product-price" data-product-price>{{ $product->formattedPrice($initialTotal) }}</p>

                <div class="product-packs" role="group" aria-label="Pack quantity">
                    @foreach ($packs as $index => $pack)
                        @php
                            $label = $pack['pcs'].' Pcs ('.$pack['unit_price'].'/Pcs)';
                            $total = round($pack['pcs'] * $pack['unit_price'], 2);
                        @endphp
                        <button
                            type="button"
                            class="product-pack-btn {{ $index === 0 ? 'is-active' : '' }}"
                            data-product-pack
                            data-pcs="{{ $pack['pcs'] }}"
                            data-unit="{{ $pack['unit_price'] }}"
                            data-total="{{ $total }}"
                            data-price-label="{{ $product->formattedPrice($total) }}"
                        >
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                <div class="product-qty-wrap">
                    <label class="sr-only" for="product-qty">Quantity</label>
                    <div class="product-qty">
                        <button type="button" class="product-qty-btn" data-qty-minus aria-label="Decrease quantity">−</button>
                        <input
                            id="product-qty"
                            type="number"
                            min="1"
                            value="1"
                            class="product-qty-input"
                            data-qty-input
                        >
                        <button type="button" class="product-qty-btn" data-qty-plus aria-label="Increase quantity">+</button>
                    </div>
                </div>

                <div class="product-actions">
                    <button type="button" class="product-btn product-btn-outline">Add to cart</button>
                    <button type="button" class="product-btn product-btn-solid">Buy it now</button>
                </div>

                <p class="product-short-desc">{{ $product->defaultShortDescription() }}</p>

                <div class="product-long-desc">
                    {!! $product->defaultDescriptionHtml() !!}
                </div>

                <div class="product-accordion" data-product-accordion>
                    <button
                        type="button"
                        class="product-accordion-trigger"
                        data-accordion-trigger
                        aria-expanded="false"
                        aria-controls="shipping-delivery-panel"
                        id="shipping-delivery-trigger"
                    >
                        <span class="product-accordion-label">
                            <svg class="product-accordion-truck" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M21.47,11.185l-1.03-1.43a2.5,2.5,0,0,0-2.03-1.05H14.03V6.565a2.5,2.5,0,0,0-2.5-2.5H4.56a2.507,2.507,0,0,0-2.5,2.5v9.94a1.5,1.5,0,0,0,1.5,1.5H4.78a2.242,2.242,0,0,0,4.44,0h5.56a2.242,2.242,0,0,0,4.44,0h1.22a1.5,1.5,0,0,0,1.5-1.5v-3.87A2.508,2.508,0,0,0,21.47,11.185ZM7,18.935a1.25,1.25,0,1,1,1.25-1.25A1.25,1.25,0,0,1,7,18.935Zm6.03-1.93H9.15a2.257,2.257,0,0,0-4.3,0H3.56a.5.5,0,0,1-.5-.5V6.565a1.5,1.5,0,0,1,1.5-1.5h6.97a1.5,1.5,0,0,1,1.5,1.5ZM17,18.935a1.25,1.25,0,1,1,1.25-1.25A1.25,1.25,0,0,1,17,18.935Zm3.94-2.43a.5.5,0,0,1-.5.5H19.15a2.257,2.257,0,0,0-4.3,0h-.82v-7.3h4.38a1.516,1.516,0,0,1,1.22.63l1.03,1.43a1.527,1.527,0,0,1,.28.87Z"/>
                                <path d="M18.029,12.205h-2a.5.5,0,0,1,0-1h2a.5.5,0,0,1,0,1Z"/>
                            </svg>
                            <span>Shipping and Delivery</span>
                        </span>
                        <svg class="product-accordion-icon" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                            <path d="M3.5 6l4.5 4.5L12.5 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <div
                        id="shipping-delivery-panel"
                        class="product-accordion-panel"
                        data-accordion-panel
                        role="region"
                        aria-labelledby="shipping-delivery-trigger"
                        hidden
                    >
                        <h4 class="product-accordion-subtitle">Shipping policy</h4>
                        <p>Most orders are delivered within 7-9 business days. Monday to Friday are considered as business days except for public holidays.</p>
                        <p>Delays in delivery can occasionally occur around public holidays or at times because of unforeseen circumstances, but we do our best to provide timely deliveries to all our customers.</p>
                        <p>Orders once placed, cannot be cancelled.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="related-products-section">
    <div class="container">
        <h2 class="related-products-heading">You may also like</h2>

        <div class="best-sellers-grid best-sellers-grid--4">
            @forelse ($relatedProducts ?? [] as $related)
                <a href="{{ route('products.show', $related->slug) }}" class="product-card">
                    <div class="product-card-media">
                        @if ($related->imageUrl())
                            <img src="{{ $related->imageUrl() }}" alt="{{ $related->name }}" loading="lazy">
                        @else
                            <div class="product-card-placeholder" aria-hidden="true"></div>
                        @endif
                    </div>
                    <h3 class="product-card-title">{{ $related->name }}</h3>
                    <p class="product-card-price">{{ $related->formattedPriceFrom() }}</p>
                </a>
            @empty
                <p class="text-sm text-brand-ink/55">No related products yet.</p>
            @endforelse
        </div>
    </div>
</section>

<div class="product-lightbox" data-product-lightbox hidden>
    <button type="button" class="product-lightbox-close" data-product-lightbox-close aria-label="Close zoom">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
            <path d="M6 6l12 12M18 6L6 18" stroke-linecap="round"/>
        </svg>
    </button>
    <div class="product-lightbox-inner">
        <img src="" alt="{{ $product->name }}" data-product-lightbox-image>
        <div class="product-gallery-placeholder product-lightbox-placeholder" data-product-lightbox-placeholder hidden aria-hidden="true"></div>
    </div>
</div>
@endsection
