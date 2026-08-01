@extends('admin.layouts.app')

@section('title', 'Edit Collection')
@section('heading', 'Edit Collection Item')
@section('subheading', 'Update category/subcategory for the homepage Collections grid')

@section('content')
    <form method="POST" action="{{ route('admin.home-collection-items.update', $item) }}" class="rounded-xl border border-brand-ink/10 bg-white p-5">
        @csrf
        @method('PUT')
        @include('admin.home-page.collections._form')
    </form>
@endsection
