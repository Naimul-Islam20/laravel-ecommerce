<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Admin Login — xperciainc</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center bg-brand-mist px-4 text-brand-ink antialiased">
    <div class="w-full max-w-md rounded-2xl border border-brand-ink/10 bg-white p-8 shadow-sm">
        <div class="mb-8 text-center">
            <h1 class="font-display text-2xl font-semibold">Admin Login</h1>
            <p class="mt-2 text-sm text-brand-ink/60">Sign in to manage the storefront</p>
        </div>

        <form method="POST" action="{{ route('admin.login.store') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="mb-1 block text-sm font-medium">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                       class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm outline-none focus:border-brand-wave">
                @error('email')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="mb-1 block text-sm font-medium">Password</label>
                <input id="password" name="password" type="password" required
                       class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm outline-none focus:border-brand-wave">
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember" value="1" class="rounded border-brand-ink/20">
                Remember me
            </label>

            <button type="submit" class="w-full rounded-lg bg-brand-ink px-4 py-2.5 text-sm font-medium text-white hover:bg-brand-ink/90">
                Sign in
            </button>
        </form>
    </div>
</body>
</html>
