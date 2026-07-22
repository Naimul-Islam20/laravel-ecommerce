<section class="hero" aria-label="Featured" data-hero-slider>
    <div class="hero-bg">
        @forelse ($heroSlides as $index => $slide)
            <div class="hero-slide {{ $index === 0 ? 'is-active' : '' }}" data-slide>
                <img src="{{ $slide->imageUrl() }}" alt="{{ $slide->alt_text ?: 'xperciainc hero slide' }}" width="1983" height="793">
            </div>
        @empty
            <div class="hero-slide is-active" data-slide>
                <img src="{{ asset('images/hero-7.png') }}" alt="xperciainc eco-friendly packaging" width="1983" height="793">
            </div>
        @endforelse
    </div>

    <div class="hero-cta">
        <div class="container">
            <a href="{{ $homeSettings->heroCtaHref() }}" class="hero-shop-btn">
                {{ $homeSettings->hero_cta_text }}
            </a>
        </div>
    </div>
</section>

@if ($heroSlides->count() > 1)
    <div class="hero-pagination" data-hero-controls>
        <button type="button" class="hero-ctrl" data-hero-prev aria-label="Previous slide">
            <svg class="h-4 w-4" viewBox="0 0 16 16" fill="none" aria-hidden="true">
                <path d="M10 3L5 8l5 5" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        <div class="flex items-center gap-2" data-hero-dots role="tablist" aria-label="Slides">
            @foreach ($heroSlides as $index => $slide)
                <button type="button"
                        class="hero-dot {{ $index === 0 ? 'is-active' : '' }}"
                        data-hero-dot="{{ $index }}"
                        aria-label="Go to slide {{ $index + 1 }}"></button>
            @endforeach
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
@endif
