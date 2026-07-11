<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'xperciainc') — Eco-friendly Disposable Packaging</title>
    <meta name="description" content="@yield('meta_description', 'xperciainc offers a wide range of disposable food packaging for restaurants, cloud kitchens, catering, and takeaways.')">
    <link rel="preconnect" href="https://fonts.bunny.net">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white text-brand-ink antialiased">
    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @include('partials.footer')

    @include('partials.search-overlay')
</body>
</html>
