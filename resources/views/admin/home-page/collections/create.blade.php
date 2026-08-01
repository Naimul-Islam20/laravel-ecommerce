@extends('admin.layouts.app')

@section('title', 'Add Collection')
@section('heading', 'Add Collection Item')
@section('subheading', 'Choose a category or subcategory for the homepage Collections grid')

@section('content')
    <form method="POST" action="{{ route('admin.home-collection-items.store') }}" class="rounded-xl border border-brand-ink/10 bg-white p-5">
        @csrf
        @include('admin.home-page.collections._form')
    </form>
@endsection
