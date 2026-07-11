<footer id="contact" class="border-t border-black/8 bg-[#f7f8f9]">
    <div class="container py-14 lg:py-16">
        <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-4 lg:gap-8">
            <div class="lg:col-span-1">
                <a href="{{ route('home') }}" class="inline-flex flex-col items-start gap-1">
                    <img src="{{ asset('images/logo-mark.svg') }}" alt="" class="h-8 w-8" width="32" height="32">
                    <span class="font-display text-base font-bold tracking-[0.18em] text-brand-ink">XPERCIAINC</span>
                </a>
                <p class="mt-4 max-w-xs text-sm leading-relaxed text-brand-ink/65">
                    Eco-friendly disposable food packaging for restaurants, cloud kitchens, catering, and takeaways.
                </p>
            </div>

            <div>
                <h3 class="text-xs font-semibold uppercase tracking-[0.14em] text-brand-ink">Shop</h3>
                <ul class="mt-4 space-y-2.5 text-sm text-brand-ink/70">
                    <li><a href="{{ route('home') }}#collections" class="transition hover:text-brand-ink">Our Collection</a></li>
                    <li><a href="{{ route('home') }}#shop" class="transition hover:text-brand-ink">All Products</a></li>
                    <li><a href="{{ route('home') }}#bulk" class="transition hover:text-brand-ink">Bulk Orders</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-xs font-semibold uppercase tracking-[0.14em] text-brand-ink">Company</h3>
                <ul class="mt-4 space-y-2.5 text-sm text-brand-ink/70">
                    <li><a href="{{ route('home') }}" class="transition hover:text-brand-ink">About</a></li>
                    <li><a href="{{ route('home') }}#contact" class="transition hover:text-brand-ink">Contact Us</a></li>
                    <li><a href="#" class="transition hover:text-brand-ink">Shipping &amp; Returns</a></li>
                </ul>
            </div>

            <div>
                <h3 class="text-xs font-semibold uppercase tracking-[0.14em] text-brand-ink">Stay in touch</h3>
                <p class="mt-4 text-sm text-brand-ink/65">Get updates on new packaging and bulk offers.</p>
                <form class="mt-4 flex gap-2" action="#" method="post" onsubmit="return false;">
                    <label class="sr-only" for="footer-email">Email</label>
                    <input
                        id="footer-email"
                        type="email"
                        placeholder="Email address"
                        class="w-full border border-black/15 bg-white px-3 py-2.5 text-sm outline-none transition focus:border-brand-ink"
                    >
                    <button type="submit" class="shrink-0 bg-brand-ink px-4 py-2.5 text-sm font-medium text-white transition hover:bg-black">
                        Join
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="border-t border-black/8">
        <div class="container flex flex-col items-center justify-between gap-3 py-5 text-xs text-brand-ink/55 sm:flex-row">
            <p>&copy; {{ date('Y') }} xperciainc. All rights reserved.</p>
            <div class="flex gap-5">
                <a href="#" class="transition hover:text-brand-ink">Privacy</a>
                <a href="#" class="transition hover:text-brand-ink">Terms</a>
            </div>
        </div>
    </div>
</footer>
