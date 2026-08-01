<form class="collection-toolbar" method="get" action="{{ $filterAction }}" data-collection-filters>
    <div class="collection-mobile-toolbar">
        <button type="button" class="collection-mobile-filter-btn" data-mobile-filter-open>
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                <path d="M4 6h16M7 12h10M10 18h4" stroke-linecap="round"/>
            </svg>
            Filter and sort
        </button>
        <p class="collection-count collection-count--mobile" data-collection-count-wrap>
            <span class="collection-count-spinner" data-collection-count-spinner hidden aria-hidden="true"></span>
            <span data-collection-count>{{ $productCount }} {{ $productCount === 1 ? 'product' : 'products' }}</span>
        </p>
    </div>

    <button type="button" class="collection-filter-drawer-backdrop" data-mobile-filter-close hidden aria-label="Close filters"></button>

    <aside class="collection-filter-controls" data-mobile-filter-drawer aria-label="Filter and sort">
        <div class="collection-filter-drawer-head">
            <h2>Filter and sort</h2>
            <button type="button" data-mobile-filter-close aria-label="Close filters">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path d="M6 6l12 12M18 6L6 18" stroke-linecap="round"/>
                </svg>
            </button>
        </div>

        <div class="collection-filter-controls-body">
            <div class="collection-toolbar-left">
                <span class="collection-toolbar-label collection-filter-prefix">Filter:</span>

                <div class="collection-filter" data-filter-dropdown data-availability-filter>
                    <button type="button" class="collection-filter-btn" data-filter-toggle aria-expanded="false">
                        Availability
                        <svg viewBox="0 0 16 16" fill="none" aria-hidden="true">
                            <path d="M3.5 6l4.5 4.5L12.5 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <div class="collection-filter-menu collection-filter-menu--panel" data-filter-menu hidden>
                        <div class="collection-filter-panel-head">
                            <p class="collection-filter-panel-title" data-availability-selected>0 selected</p>
                        </div>
                        <div class="collection-filter-panel-options">
                            <label class="collection-filter-option">
                                <input type="checkbox" name="availability[]" value="in-stock" data-availability-option
                                       {{ in_array('in-stock', (array) ($filters['availability'] ?? []), true) ? 'checked' : '' }}>
                                <span>In stock</span>
                            </label>
                            <label class="collection-filter-option">
                                <input type="checkbox" name="availability[]" value="out-of-stock" data-availability-option
                                       {{ in_array('out-of-stock', (array) ($filters['availability'] ?? []), true) ? 'checked' : '' }}>
                                <span>Out of stock</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="collection-filter" data-filter-dropdown data-price-filter>
                    <button type="button" class="collection-filter-btn" data-filter-toggle aria-expanded="false">
                        Price
                        <svg viewBox="0 0 16 16" fill="none" aria-hidden="true">
                            <path d="M3.5 6l4.5 4.5L12.5 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <div class="collection-filter-menu collection-filter-menu--panel collection-filter-menu--price" data-filter-menu hidden>
                        <div class="collection-filter-panel-head">
                            <p class="collection-filter-panel-title">
                                The highest price is {{ ($siteSettings?->currencyLabel() ?? 'Rs.') }} {{ number_format($highestPrice ?? 0, 2) }}
                            </p>
                        </div>
                        <div class="collection-price-fields">
                            @foreach (['min' => 'From', 'max' => 'To'] as $priceKey => $priceLabel)
                                <label class="collection-price-field">
                                    <span class="collection-price-row">
                                        <span class="collection-price-currency">{{ $siteSettings?->currencyLabel() ?? 'Rs.' }}</span>
                                        <span class="collection-price-input-wrap">
                                            <input type="text"
                                                   name="{{ $priceKey }}_price"
                                                   inputmode="decimal"
                                                   autocomplete="off"
                                                   value=""
                                                   data-price-{{ $priceKey }}
                                                   placeholder=" ">
                                            <span class="collection-price-field-label">{{ $priceLabel }}</span>
                                        </span>
                                    </span>
                                </label>
                            @endforeach
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
                                <path d="M3.5 6l4.5 4.5L12.5 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </button>
                        <div class="collection-filter-menu collection-filter-menu--panel collection-filter-menu--sort" data-filter-menu hidden>
                            <div class="collection-filter-panel-options">
                                @foreach ([
                                    'featured' => 'Featured',
                                    'price-asc' => 'Price, low to high',
                                    'price-desc' => 'Price, high to low',
                                    'title-asc' => 'Alphabetically, A-Z',
                                    'title-desc' => 'Alphabetically, Z-A',
                                ] as $sortValue => $sortText)
                                    <label class="collection-filter-option">
                                        <input type="radio" name="sort" value="{{ $sortValue }}" data-sort-option
                                               {{ ($filters['sort'] ?? 'featured') === $sortValue ? 'checked' : '' }}>
                                        <span>{{ $sortText }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <p class="collection-count collection-count--desktop" data-collection-count-wrap>
                    <span class="collection-count-spinner" data-collection-count-spinner hidden aria-hidden="true"></span>
                    <span data-collection-count>{{ $productCount }} {{ $productCount === 1 ? 'product' : 'products' }}</span>
                </p>
            </div>
        </div>

        <div class="collection-filter-drawer-footer">
            <button type="button" data-mobile-filter-close>View products</button>
        </div>
    </aside>
</form>
