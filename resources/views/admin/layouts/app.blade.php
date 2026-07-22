<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Admin') — xperciainc</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-brand-mist text-brand-ink antialiased">
    @php
        $adminNav = [
            [
                'route' => 'admin.dashboard',
                'label' => 'Dashboard',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
            ],
            [
                'route' => 'admin.home-page.index',
                'label' => 'Home Page',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm0 8a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zm10 0a1 1 0 011-1h4a1 1 0 011 1v6a1 1 0 01-1 1h-4a1 1 0 01-1-1v-6z"/>',
            ],
            [
                'route' => 'admin.products.index',
                'label' => 'Products',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>',
            ],
            [
                'route' => 'admin.categories.index',
                'label' => 'Categories',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a4 4 0 014-4z"/>',
            ],
            [
                'route' => 'admin.subcategories.index',
                'label' => 'Subcategories',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h10M4 14h16M4 18h10"/>',
            ],
            [
                'route' => 'admin.admins.index',
                'label' => 'Admins',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>',
            ],
        ];
    @endphp

    <div class="flex min-h-screen">
        <aside class="hidden w-64 shrink-0 border-r border-brand-ink/10 bg-white lg:block">
            <div class="border-b border-brand-ink/10 px-6 py-5">
                <a href="{{ route('admin.dashboard') }}" class="font-display text-lg font-semibold tracking-tight">
                    xperciainc Admin
                </a>
            </div>
            <nav class="space-y-1 p-4">
                @foreach ($adminNav as $item)
                    @php
                        $isActive = request()->routeIs(str_replace('.index', '.*', $item['route'])) || request()->routeIs($item['route']);
                    @endphp
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition {{ $isActive ? 'bg-brand-ink text-white' : 'text-brand-ink/70 hover:bg-brand-mist hover:text-brand-ink' }}">
                        <svg class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                            {!! $item['icon'] !!}
                        </svg>
                        <span>{{ $item['label'] }}</span>
                    </a>
                @endforeach
            </nav>
        </aside>

        <div class="flex min-w-0 flex-1 flex-col">
            <header class="border-b border-brand-ink/10 bg-white px-4 py-4 sm:px-6">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h1 class="font-display text-xl font-semibold">@yield('heading', 'Dashboard')</h1>
                        @hasSection('subheading')
                            <p class="mt-1 text-sm text-brand-ink/60">@yield('subheading')</p>
                        @endif
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="hidden text-sm text-brand-ink/60 sm:inline">{{ auth()->user()->name }}</span>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg border border-brand-ink/15 px-3 py-1.5 text-sm font-medium hover:bg-brand-mist">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
                <nav class="mt-4 flex gap-2 overflow-x-auto lg:hidden">
                    @foreach ($adminNav as $item)
                        @php
                            $isActive = request()->routeIs(str_replace('.index', '.*', $item['route'])) || request()->routeIs($item['route']);
                        @endphp
                        <a href="{{ route($item['route']) }}"
                           class="inline-flex shrink-0 items-center gap-1.5 whitespace-nowrap rounded-full px-3 py-1.5 text-xs font-medium {{ $isActive ? 'bg-brand-ink text-white' : 'bg-brand-mist text-brand-ink/70' }}">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                                {!! $item['icon'] !!}
                            </svg>
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>
            </header>

            <main class="flex-1 p-4 sm:p-6">
                @if (session('success'))
                    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
