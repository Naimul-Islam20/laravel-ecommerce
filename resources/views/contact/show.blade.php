@extends('layouts.app')

@section('title', 'Contact')
@section('meta_description', 'Contact XPERCIAINC for product inquiries, bulk orders, and support.')

@section('content')
<section class="contact-page">
    <div class="container">
        <h1 class="contact-page-title scroll-reveal">Contact</h1>

        @if (session('success'))
            <p class="contact-success scroll-reveal" role="status">{{ session('success') }}</p>
        @endif

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
    </div>
</section>
@endsection
