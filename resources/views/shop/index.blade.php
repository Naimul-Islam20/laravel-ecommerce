@extends('layouts.app')

@section('title', $title)
@section('meta_description', 'Shop all products from XPERCIAINC')

@section('content')
<section class="collection-page">
    <div class="container">
        <h1 class="collection-page-title">{{ $title }}</h1>

        @include('partials.collection-filters', [
            'filterAction' => route('shop'),
        ])

        @include('partials.collection-product-grid', [
            'emptyMessage' => 'No products found.',
        ])

        @if ($products->hasPages())
            <nav class="shop-pagination" aria-label="Pagination">
                {{ $products->onEachSide(1)->links('pagination.shop') }}
            </nav>
        @endif
    </div>
</section>
@endsection
