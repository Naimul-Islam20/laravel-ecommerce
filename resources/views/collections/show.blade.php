@extends('layouts.app')

@section('title', $title)
@section('meta_description', $title.' products from XPERCIAINC')

@section('content')
<section class="collection-page">
    <div class="container">
        <h1 class="collection-page-title">{{ $title }}</h1>

        @include('partials.collection-filters', [
            'filterAction' => route('collections.show', $collectionSlug),
        ])

        @include('partials.collection-product-grid', [
            'emptyMessage' => 'No products found in this collection.',
        ])
    </div>
</section>
@endsection
