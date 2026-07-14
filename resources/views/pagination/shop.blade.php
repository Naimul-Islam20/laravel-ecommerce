@if ($paginator->hasPages())
    <ul class="shop-pagination-list">
        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <li class="shop-pagination-item is-disabled" aria-disabled="true">
                <span class="shop-pagination-link" aria-label="Previous">
                    <svg viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M10 3L5 8l5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </li>
        @else
            <li class="shop-pagination-item">
                <a href="{{ $paginator->previousPageUrl() }}" class="shop-pagination-link" rel="prev" aria-label="Previous">
                    <svg viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M10 3L5 8l5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </li>
        @endif

        {{-- Page numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="shop-pagination-item is-ellipsis" aria-disabled="true">
                    <span class="shop-pagination-link">{{ $element }}</span>
                </li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="shop-pagination-item is-active" aria-current="page">
                            <span class="shop-pagination-link">{{ $page }}</span>
                        </li>
                    @else
                        <li class="shop-pagination-item">
                            <a href="{{ $url }}" class="shop-pagination-link">{{ $page }}</a>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <li class="shop-pagination-item">
                <a href="{{ $paginator->nextPageUrl() }}" class="shop-pagination-link" rel="next" aria-label="Next">
                    <svg viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M6 3l5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
            </li>
        @else
            <li class="shop-pagination-item is-disabled" aria-disabled="true">
                <span class="shop-pagination-link" aria-label="Next">
                    <svg viewBox="0 0 16 16" fill="none" aria-hidden="true">
                        <path d="M6 3l5 5-5 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </li>
        @endif
    </ul>
@endif
