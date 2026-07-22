@extends('admin.layouts.app')

@section('title', 'Edit Product')
@section('heading', 'Edit Product')

@section('content')
    <form method="POST" action="{{ route('admin.products.update', $product) }}" class="rounded-xl border border-brand-ink/10 bg-white p-5">
        @csrf
        @method('PUT')
        @include('admin.products._form')
    </form>
@endsection
