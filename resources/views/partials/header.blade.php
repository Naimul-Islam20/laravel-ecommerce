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

            <a href="{{ route('home') }}#shop" class="nav-link">Shop</a>
            <a href="{{ route('home') }}#bulk" class="nav-link">Bulk Orders</a>
            <a href="{{ route('home') }}#contact" class="nav-link">Contact Us</a>
        </nav>

        {{-- Mobile menu button --}}
        <button type="button" class="inline-flex h-10 w-10 items-center justify-center lg:hidden" id="mobile-menu-toggle" aria-label="Open menu" aria-expanded="false">
            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M4 7h16M4 12h16M4 17h16" stroke-linecap="round"/>
            </svg>
        </button>

        {{-- Center logo --}}
        <a href="{{ route('home') }}" class="absolute left-1/2 flex -translate-x-1/2 flex-col items-center gap-0.5">
            <img src="{{ asset('images/logo-mark.svg') }}" alt="" class="h-7 w-7" width="28" height="28">
            <span class="font-display text-[15px] font-bold tracking-[0.18em] text-brand-ink">XPERCIAINC</span>
        </a>

        {{-- Right utilities --}}
        <div class="flex items-center gap-3 sm:gap-4">
            <button type="button" class="hidden items-center gap-1 text-[13px] text-brand-ink/80 transition hover:text-brand-ink md:inline-flex">
                <span>Åland Islands | INR ₹</span>
                <svg class="h-3 w-3 opacity-70" viewBox="0 0 12 12" fill="none" aria-hidden="true">
                    <path d="M2.5 4.5L6 8l3.5-3.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

            <button type="button" class="header-icon" aria-label="Search" data-search-open>
                <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                    <circle cx="11" cy="11" r="7"/>
                    <path d="M20 20l-3.5-3.5" stroke-linecap="round"/>
                </svg>
            </button>

            <button type="button" class="header-icon" aria-label="Account">
                <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                    <circle cx="12" cy="8" r="3.5"/>
                    <path d="M5 19.5c1.8-3.2 4.2-4.8 7-4.8s5.2 1.6 7 4.8" stroke-linecap="round"/>
                </svg>
            </button>

            <button type="button" class="header-icon relative" aria-label="Cart">
                <svg class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                    <path d="M6.5 8.5h11l-1 11h-9l-1-11z" stroke-linejoin="round"/>
                    <path d="M9 8.5V7a3 3 0 016 0v1.5" stroke-linecap="round"/>
                </svg>
                <span class="absolute -right-1.5 -top-1.5 flex h-4 min-w-4 items-center justify-center rounded-full bg-brand-ink px-1 text-[10px] font-semibold leading-none text-white">0</span>
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
                        <a href="{{ url('/collections/'.$category->slug) }}" class="collection-mega-title">
                            {{ $category->name }}
                        </a>
                        @if ($category->children->isNotEmpty())
                            <ul class="collection-mega-list">
                                @foreach ($category->children as $child)
                                    <li>
                                        <a href="{{ url('/collections/'.$child->slug) }}" class="collection-mega-link">
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
                        <a href="{{ url('/collections/'.$category->slug) }}" class="collection-mega-title">
                            {{ $category->name }}
                        </a>
                        @if ($category->children->isNotEmpty())
                            <ul class="collection-mega-list">
                                @foreach ($category->children as $child)
                                    <li>
                                        <a href="{{ url('/collections/'.$child->slug) }}" class="collection-mega-link">
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

    {{-- Mobile nav --}}
    <div id="mobile-menu" class="hidden border-t border-black/5 bg-white lg:hidden">
        <nav class="flex flex-col gap-1 px-5 py-4" aria-label="Mobile">
            <a href="{{ route('home') }}" class="py-2 text-sm font-medium">Home</a>

            <div class="border-t border-black/5 pt-2">
                <p class="py-2 text-xs font-semibold uppercase tracking-[0.12em] text-brand-ink/50">Our Collection</p>
                @foreach ($menuColumns ?? [] as $column => $categories)
                    @foreach ($categories->sortBy('menu_row') as $category)
                        <a href="{{ url('/collections/'.$category->slug) }}" class="block py-1.5 text-sm font-medium text-brand-ink">
                            {{ $category->name }}
                        </a>
                        @foreach ($category->children as $child)
                            <a href="{{ url('/collections/'.$child->slug) }}" class="block py-1 pl-3 text-sm text-brand-ink/70">
                                {{ $child->name }}
                            </a>
                        @endforeach
                    @endforeach
                @endforeach
            </div>

            <a href="{{ route('home') }}#shop" class="mt-2 border-t border-black/5 py-2 text-sm font-medium">Shop</a>
            <a href="{{ route('home') }}#bulk" class="py-2 text-sm font-medium">Bulk Orders</a>
            <a href="{{ route('home') }}#contact" class="py-2 text-sm font-medium">Contact Us</a>
        </nav>
    </div>
</header>
