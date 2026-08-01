@extends('layouts.app')

@php
    $site = $siteSettings ?? null;
    $siteName = $site?->site_name ?: 'XPERCIAINC';
    $companyName = $site?->company_name;
    $phone = $site?->phone;
    $email = $site?->email;
    $address = $site?->address;
    $gstin = $site?->gstin;
    $mapUrl = $site?->mapsHref() ?? '#';
    $mapEmbed = $site?->mapsEmbedUrl();
    $facebookUrl = $site?->facebook_url;
    $instagramUrl = $site?->instagram_url;
    $youtubeUrl = $site?->youtube_url;
    $hasContactDetails = $companyName || $phone || $email || $address || $gstin;
@endphp

@section('title', 'Contact')
@section('meta_description', 'Contact '.$siteName.($phone ? ' at '.$phone : '').($email ? ' or '.$email : '').' for product inquiries, bulk orders, and support.')

@section('content')
<section class="contact-page">
    <div class="container">
        <h1 class="contact-page-title scroll-reveal">Contact</h1>

        @if (session('success'))
            <p class="contact-success scroll-reveal" role="status">{{ session('success') }}</p>
        @endif

        <div class="contact-layout">
            <form
                class="contact-form scroll-reveal"
                method="post"
                action="{{ route('contact.store') }}"
                data-contact-form
                novalidate
            >
                @csrf

                <div class="contact-form-row">
                    <label class="contact-field">
                        <span class="contact-field-wrap {{ old('name') ? 'is-filled' : '' }}">
                            <input
                                type="text"
                                name="name"
                                id="contact-name"
                                value="{{ old('name') }}"
                                autocomplete="name"
                                placeholder=" "
                            >
                            <span class="contact-field-label">Name</span>
                        </span>
                        @error('name')
                            <span class="contact-field-error">{{ $message }}</span>
                        @enderror
                    </label>

                    <label class="contact-field">
                        <span class="contact-field-wrap {{ old('email') ? 'is-filled' : '' }}">
                            <input
                                type="email"
                                name="email"
                                id="contact-email"
                                value="{{ old('email') }}"
                                autocomplete="email"
                                required
                                placeholder=" "
                            >
                            <span class="contact-field-label">Email</span>
                        </span>
                        @error('email')
                            <span class="contact-field-error">{{ $message }}</span>
                        @enderror
                    </label>
                </div>

                <label class="contact-field">
                    <span class="contact-field-wrap {{ old('phone') ? 'is-filled' : '' }}">
                        <input
                            type="tel"
                            name="phone"
                            id="contact-phone"
                            value="{{ old('phone') }}"
                            autocomplete="tel"
                            inputmode="tel"
                            placeholder=" "
                        >
                        <span class="contact-field-label">Phone number</span>
                    </span>
                    @error('phone')
                        <span class="contact-field-error">{{ $message }}</span>
                    @enderror
                </label>

                <label class="contact-field">
                    <span class="contact-field-wrap contact-field-wrap--textarea {{ old('comment') ? 'is-filled' : '' }}">
                        <textarea
                            name="comment"
                            id="contact-comment"
                            rows="6"
                            placeholder=" "
                        >{{ old('comment') }}</textarea>
                        <span class="contact-field-label">Comment</span>
                    </span>
                    @error('comment')
                        <span class="contact-field-error">{{ $message }}</span>
                    @enderror
                </label>

                <button type="submit" class="contact-submit">Send</button>
            </form>

            @if ($hasContactDetails || $facebookUrl || $instagramUrl || $youtubeUrl)
                <aside class="contact-details scroll-reveal" aria-label="Contact details">
                    <h2 class="contact-details-title">{{ $siteName }}</h2>

                    @if ($hasContactDetails)
                        <ul class="contact-details-list">
                            @if ($companyName)
                                <li>
                                    <span class="contact-details-label">Company</span>
                                    <span>{{ $companyName }}</span>
                                </li>
                            @endif
                            @if ($phone)
                                <li>
                                    <span class="contact-details-label">Phone</span>
                                    <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}">{{ $phone }}</a>
                                </li>
                            @endif
                            @if ($email)
                                <li>
                                    <span class="contact-details-label">Email</span>
                                    <a href="mailto:{{ $email }}">{{ $email }}</a>
                                </li>
                            @endif
                            @if ($address)
                                <li>
                                    <span class="contact-details-label">Address</span>
                                    <a href="{{ $mapUrl }}" target="_blank" rel="noopener noreferrer">{{ $address }}</a>
                                </li>
                            @endif
                            @if ($gstin)
                                <li>
                                    <span class="contact-details-label">GSTIN</span>
                                    <span>{{ $gstin }}</span>
                                </li>
                            @endif
                        </ul>
                    @endif

                    @if ($facebookUrl || $instagramUrl || $youtubeUrl)
                        <div class="contact-social">
                            @if ($facebookUrl)
                                <a href="{{ $facebookUrl }}" class="contact-social-link" aria-label="Facebook" target="_blank" rel="noopener noreferrer">
                                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M12 2.04C6.5 2.04 2 6.53 2 12.06c0 5 3.66 9.15 8.44 9.9v-7H7.9v-2.9h2.54V9.85c0-2.51 1.49-3.89 3.78-3.89 1.09 0 2.23.19 2.23.19v2.47h-1.26c-1.24 0-1.63.77-1.63 1.56v1.88h2.78l-.45 2.9h-2.33v7a10 10 0 0 0 8.44-9.9c0-5.53-4.5-10.02-10-10.02z"/>
                                    </svg>
                                </a>
                            @endif
                            @if ($instagramUrl)
                                <a href="{{ $instagramUrl }}" class="contact-social-link" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                        <rect x="3.5" y="3.5" width="17" height="17" rx="4.5"/>
                                        <circle cx="12" cy="12" r="4"/>
                                        <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
                                    </svg>
                                </a>
                            @endif
                            @if ($youtubeUrl)
                                <a href="{{ $youtubeUrl }}" class="contact-social-link" aria-label="YouTube" target="_blank" rel="noopener noreferrer">
                                    <svg viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path d="M23.5 6.2a3 3 0 0 0-2.1-2.1C19.5 3.5 12 3.5 12 3.5s-7.5 0-9.4.6A3 3 0 0 0 .5 6.2 31.5 31.5 0 0 0 0 12a31.5 31.5 0 0 0 .5 5.8 3 3 0 0 0 2.1 2.1c1.9.6 9.4.6 9.4.6s7.5 0 9.4-.6a3 3 0 0 0 2.1-2.1A31.5 31.5 0 0 0 24 12a31.5 31.5 0 0 0-.5-5.8zM9.75 15.5v-7l6.5 3.5-6.5 3.5z"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    @endif

                </aside>
            @endif

            @if ($mapEmbed)
                <div class="contact-map scroll-reveal">
                    <iframe
                        src="{{ $mapEmbed }}"
                        title="{{ $siteName }} location map"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        allowfullscreen
                    ></iframe>
                </div>
            @endif
        </div>
    </div>
</section>
@endsection
