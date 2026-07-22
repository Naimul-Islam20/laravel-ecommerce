@extends('admin.layouts.app')

@section('title', 'Create Subcategory')
@section('heading', 'Create Subcategory')

@section('content')
    <form method="POST" action="{{ route('admin.subcategories.store') }}" class="rounded-xl border border-brand-ink/10 bg-white p-5">
        @csrf
        @include('admin.subcategories._form')
    </form>
@endsection
