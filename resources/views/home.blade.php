@extends('layouts.app')

@section('title', 'Home')

@section('content')
@include('partials.home.hero', [
    'homeSettings' => $homeSettings,
    'heroSlides' => $heroSlides,
])

@include('partials.home.collections', [
    'collections' => $collections,
])

@foreach ($homeSections as $section)
    @include('partials.home.product-section', ['section' => $section])
@endforeach

<div id="shop" class="sr-only" aria-hidden="true"></div>
<div id="bulk" class="sr-only" aria-hidden="true"></div>
@endsection
