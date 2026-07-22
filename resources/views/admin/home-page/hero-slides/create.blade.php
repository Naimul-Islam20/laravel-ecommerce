@extends('admin.layouts.app')

@section('title', 'Add Hero Slide')
@section('heading', 'Add Hero Slide')

@section('content')
    <form method="POST" action="{{ route('admin.home-hero-slides.store') }}" class="rounded-xl border border-brand-ink/10 bg-white p-5">
        @csrf
        @include('admin.home-page.hero-slides._form')
    </form>
@endsection
