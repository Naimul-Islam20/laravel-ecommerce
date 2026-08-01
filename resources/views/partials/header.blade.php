<header class="site-header sticky top-0 z-50 border-b border-black/5 bg-white relative">
    <div class="container relative flex h-[72px] items-center justify-between gap-4">
        {{-- Left nav --}}
        <nav class="hidden items-center gap-6 lg:flex xl:gap-7" aria-label="Primary">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'is-active' : '' }}">Home</a>

            <div class="collection-nav" data-collection-nav>
                <button type="button" class="nav-link inline-flex items-center gap-1" aria-haspopup="true" aria-expanded="false" data-collection-toggle>
                    Our Collection
                    <svg class="h-3 w-3 opacity-70" viewBox="0 0 12 12" fill="none" aria-hidden="true">
                        <path d="M2.5 4.5L6 8l3.5-3.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>

            <a href="{{ route('shop') }}" class="nav-link {{ request()->routeIs('shop') ? 'is-active' : '' }}">Shop</a>
            <a href="{{ route('contact.show') }}" class="nav-link {{ request()->routeIs('contact.*') ? 'is-active' : '' }}">Contact Us</a>
        </nav>

        {{-- Mobile menu button --}}
        <button type="button" class="relative z-10 inline-flex h-10 w-10 items-center justify-center lg:hidden" id="mobile-menu-toggle" aria-label="Open menu" aria-expanded="false">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M4 7h16M4 12h16M4 17h16" stroke-linecap="round"/>
            </svg>
        </button>

        {{-- Center logo --}}
        @php
            $headerSite = $siteSettings ?? null;
            $headerSiteName = $headerSite?->site_name ?: 'XPERCIAINC';
            $headerLogo = $headerSite?->logoUrl() ?? asset('images/logo-mark.svg');
        @endphp
        <a href="{{ route('home') }}" class="absolute inset-y-1 left-1/2 z-[1] flex -translate-x-1/2 items-center px-12 sm:px-14 lg:px-0">
            <img src="{{ $headerLogo }}" alt="{{ $headerSiteName }}"
                 class="h-10 w-auto max-w-[130px] object-contain sm:h-12 sm:max-w-[160px] lg:h-16 lg:max-w-[200px]"
                 width="200" height="64">
        </a>

        {{-- Right utilities --}}
        <div class="relative z-10 flex items-center gap-3 sm:gap-4">
            <button type="button" class="header-icon" aria-label="Search" data-search-open>
                <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                    <circle cx="11" cy="11" r="7"/>
                    <path d="M20 20l-3.5-3.5" stroke-linecap="round"/>
                </svg>
            </button>
        </div>
    </div>

    {{-- Mega menu --}}
    <div class="collection-mega" data-collection-mega hidden>
        <div class="container py-8 lg:py-10">
            @php
                $columns = collect($menuColumns ?? [])->sortKeys();
                $topRow = $columns->map(fn ($cats) => $cats->firstWhere('menu_row', 1))->filter();
                $bottomRow = $columns->map(fn ($cats) => $cats->firstWhere('menu_row', 2))->filter();
            @endphp

            <div class="collection-mega-grid">
                {{-- Top row: all first categories --}}
                @foreach ($topRow as $category)
                    <div class="collection-mega-block">
                        <a href="{{ route('collections.show', $category->slug) }}" class="collection-mega-title">
                            {{ $category->name }}
                        </a>
                        @if ($category->children->isNotEmpty())
                            <ul class="collection-mega-list">
                                @foreach ($category->children as $child)
                                    <li>
                                        <a href="{{ route('collections.show', $child->slug) }}" class="collection-mega-link">
                                            {{ $child->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach

                {{-- Bottom row: starts after top row ends (aligned across columns) --}}
                @foreach ($bottomRow as $category)
                    <div class="collection-mega-block">
                        <a href="{{ route('collections.show', $category->slug) }}" class="collection-mega-title">
                            {{ $category->name }}
                        </a>
                        @if ($category->children->isNotEmpty())
                            <ul class="collection-mega-list">
                                @foreach ($category->children as $child)
                                    <li>
                                        <a href="{{ route('collections.show', $child->slug) }}" class="collection-mega-link">
                                            {{ $child->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Mobile sidebar --}}
    @php
        $mobileMenuCategories = collect($menuColumns ?? [])
            ->sortKeys()
            ->flatMap(fn ($cats) => $cats->sortBy('menu_row'))
            ->values();
    @endphp
    <div id="mobile-menu" class="mobile-sidebar lg:hidden" hidden data-mobile-sidebar>
        <button type="button" class="mobile-sidebar-backdrop" data-mobile-sidebar-close aria-label="Close menu"></button>
        <aside class="mobile-sidebar-panel" role="dialog" aria-modal="true" aria-label="Menu">
            <div class="mobile-sidebar-head">
                <img src="{{ $headerLogo }}" alt="{{ $headerSiteName }}" class="h-10 w-auto max-w-[140px] object-contain">
                <button type="button" class="mobile-sidebar-close" data-mobile-sidebar-close aria-label="Close menu">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path d="M6 6l12 12M18 6L6 18" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>
            <nav class="mobile-sidebar-nav" aria-label="Mobile">
                <a href="{{ route('home') }}" class="mobile-sidebar-link {{ request()->routeIs('home') ? 'is-active' : '' }}">Home</a>

                <div class="mobile-sidebar-group" data-mobile-accordion>
                    <button type="button" class="mobile-sidebar-accordion" data-mobile-accordion-toggle aria-expanded="false">
                        <span>Our Collection</span>
                        <svg class="h-4 w-4" viewBox="0 0 12 12" fill="none" aria-hidden="true">
                            <path d="M2.5 4.5L6 8l3.5-3.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <div class="mobile-sidebar-accordion-panel">
                        @foreach ($mobileMenuCategories as $category)
                            <a href="{{ route('collections.show', $category->slug) }}" class="mobile-sidebar-link mobile-sidebar-link--parent">
                                {{ $category->name }}
                            </a>
                            @foreach ($category->children as $child)
                                <a href="{{ route('collections.show', $child->slug) }}" class="mobile-sidebar-link mobile-sidebar-link--child">
                                    {{ $child->name }}
                                </a>
                            @endforeach
                        @endforeach
                    </div>
                </div>

                <a href="{{ route('shop') }}" class="mobile-sidebar-link {{ request()->routeIs('shop') ? 'is-active' : '' }}">Shop</a>
                <a href="{{ route('contact.show') }}" class="mobile-sidebar-link {{ request()->routeIs('contact.*') ? 'is-active' : '' }}">Contact Us</a>
            </nav>
        </aside>
    </div>
</header>
