@extends('admin.layouts.app')

@section('title', 'Edit Hero Slide')
@section('heading', 'Edit Hero Slide')

@section('content')
    <form method="POST" action="{{ route('admin.home-hero-slides.update', $slide) }}" class="rounded-xl border border-brand-ink/10 bg-white p-5">
        @csrf
        @method('PUT')
        @include('admin.home-page.hero-slides._form')
    </form>
@endsection
