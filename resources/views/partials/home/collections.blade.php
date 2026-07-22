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
