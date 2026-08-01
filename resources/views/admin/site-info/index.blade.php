@extends('admin.layouts.app')

@section('title', 'Site Info')
@section('heading', 'Site Info')
@section('subheading', 'Manage company contact details shown across the website')

@section('content')
    <div class="space-y-6">
        <section class="rounded-xl border border-brand-ink/10 bg-white p-4 sm:p-5">
            <h2 class="font-display text-lg font-semibold">Company Details</h2>
            <p class="mt-1 text-sm text-brand-ink/60">Brand name and short about text for the footer.</p>

            <form method="POST" action="{{ route('admin.site-info.update') }}" enctype="multipart/form-data" class="mt-4 grid gap-4 md:grid-cols-2">
                @csrf
                @method('PUT')

                <div>
                    <label for="site_name" class="mb-1 block text-sm font-medium">Site Name *</label>
                    <input id="site_name" name="site_name" type="text"
                           value="{{ old('site_name', $settings->site_name) }}" required
                           class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
                    @error('site_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="currency" class="mb-1 block text-sm font-medium">Currency *</label>
                    <input id="currency" name="currency" type="text"
                           value="{{ old('currency', $settings->currency ?? 'Rs.') }}" required
                           class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm"
                           placeholder="Rs. or ₹">
                    <p class="mt-1 text-xs text-brand-ink/50">Used for all product prices across the site</p>
                    @error('currency')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="company_name" class="mb-1 block text-sm font-medium">Company Name</label>
                    <input id="company_name" name="company_name" type="text"
                           value="{{ old('company_name', $settings->company_name) }}"
                           class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm"
                           placeholder="Rp Trading Company">
                    @error('company_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2 border-t border-brand-ink/10 pt-4">
                    <h3 class="font-display text-base font-semibold">Brand Images</h3>
                    <p class="mt-1 text-sm text-brand-ink/60">Logo is used in header, footer, and social share preview. Icon is used as the browser favicon.</p>
                </div>

                <div>
                    @include('admin.partials.image-upload', [
                        'name' => 'logo',
                        'label' => 'Logo',
                        'url' => $settings->logo ? $settings->logoUrl() : null,
                        'help' => 'Also used as OG / social share image',
                    ])
                </div>

                <div>
                    @include('admin.partials.image-upload', [
                        'name' => 'favicon',
                        'label' => 'Icon / Favicon',
                        'url' => $settings->favicon ? $settings->faviconUrl() : null,
                        'help' => 'Browser tab icon. Leave blank to keep current or use logo.',
                    ])
                </div>

                <div class="md:col-span-2">
                    <label for="about_text" class="mb-1 block text-sm font-medium">About Text</label>
                    <textarea id="about_text" name="about_text" rows="3"
                              class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">{{ old('about_text', $settings->about_text) }}</textarea>
                    @error('about_text')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2 border-t border-brand-ink/10 pt-4">
                    <h3 class="font-display text-base font-semibold">Contact</h3>
                    <p class="mt-1 text-sm text-brand-ink/60">Phone, email, address, and GST details.</p>
                </div>

                <div>
                    <label for="phone" class="mb-1 block text-sm font-medium">Phone / Mobile</label>
                    <input id="phone" name="phone" type="text"
                           value="{{ old('phone', $settings->phone) }}"
                           class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm"
                           placeholder="9211997415">
                    @error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="email" class="mb-1 block text-sm font-medium">Email</label>
                    <input id="email" name="email" type="email"
                           value="{{ old('email', $settings->email) }}"
                           class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm"
                           placeholder="Info@Xperciainc.com">
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label for="address" class="mb-1 block text-sm font-medium">Address</label>
                    <textarea id="address" name="address" rows="2"
                              class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">{{ old('address', $settings->address) }}</textarea>
                    @error('address')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="map_url" class="mb-1 block text-sm font-medium">Google Maps URL</label>
                    <input id="map_url" name="map_url" type="text"
                           value="{{ old('map_url', $settings->map_url) }}"
                           class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm"
                           placeholder="https://maps.google.com/?q=...">
                    <p class="mt-1 text-xs text-brand-ink/50">Optional. If empty, address will be used for the map link.</p>
                    @error('map_url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="gstin" class="mb-1 block text-sm font-medium">GSTIN</label>
                    <input id="gstin" name="gstin" type="text"
                           value="{{ old('gstin', $settings->gstin) }}"
                           class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm"
                           placeholder="07AJCPA7351H1ZI">
                    @error('gstin')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2 border-t border-brand-ink/10 pt-4">
                    <h3 class="font-display text-base font-semibold">Social Links</h3>
                    <p class="mt-1 text-sm text-brand-ink/60">Leave blank to hide a social icon.</p>
                </div>

                <div>
                    <label for="facebook_url" class="mb-1 block text-sm font-medium">Facebook URL</label>
                    <input id="facebook_url" name="facebook_url" type="text"
                           value="{{ old('facebook_url', $settings->facebook_url) }}"
                           class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm"
                           placeholder="https://facebook.com/...">
                    @error('facebook_url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="instagram_url" class="mb-1 block text-sm font-medium">Instagram URL</label>
                    <input id="instagram_url" name="instagram_url" type="text"
                           value="{{ old('instagram_url', $settings->instagram_url) }}"
                           class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm"
                           placeholder="https://instagram.com/...">
                    @error('instagram_url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="youtube_url" class="mb-1 block text-sm font-medium">YouTube URL</label>
                    <input id="youtube_url" name="youtube_url" type="text"
                           value="{{ old('youtube_url', $settings->youtube_url) }}"
                           class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm"
                           placeholder="https://youtube.com/...">
                    @error('youtube_url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2 border-t border-brand-ink/10 pt-4">
                    <h3 class="font-display text-base font-semibold">SEO / Meta Data</h3>
                    <p class="mt-1 text-sm text-brand-ink/60">Default title, description, and keywords used across the site.</p>
                </div>

                <div class="md:col-span-2">
                    <label for="meta_title" class="mb-1 block text-sm font-medium">Meta Title</label>
                    <input id="meta_title" name="meta_title" type="text"
                           value="{{ old('meta_title', $settings->meta_title) }}"
                           class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm"
                           placeholder="Eco-friendly Disposable Packaging">
                    <p class="mt-1 text-xs text-brand-ink/50">Used as the default title suffix, e.g. Home — Meta Title</p>
                    @error('meta_title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label for="meta_description" class="mb-1 block text-sm font-medium">Meta Description</label>
                    <textarea id="meta_description" name="meta_description" rows="3"
                              class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm"
                              placeholder="Short description for search engines">{{ old('meta_description', $settings->meta_description) }}</textarea>
                    @error('meta_description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label for="meta_keywords" class="mb-1 block text-sm font-medium">Meta Keywords</label>
                    <input id="meta_keywords" name="meta_keywords" type="text"
                           value="{{ old('meta_keywords', $settings->meta_keywords) }}"
                           class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm"
                           placeholder="disposable packaging, meal trays, takeaway containers">
                    <p class="mt-1 text-xs text-brand-ink/50">Comma-separated keywords</p>
                    @error('meta_keywords')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <button type="submit" class="rounded-lg bg-brand-ink px-4 py-2 text-sm font-medium text-white">
                        Save Site Info
                    </button>
                </div>
            </form>
        </section>
    </div>
@endsection
