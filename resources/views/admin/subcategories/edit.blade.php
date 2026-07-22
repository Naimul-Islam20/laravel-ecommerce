@extends('admin.layouts.app')

@section('title', 'Edit Subcategory')
@section('heading', 'Edit Subcategory')

@section('content')
    <form method="POST" action="{{ route('admin.subcategories.update', $subcategory) }}" class="rounded-xl border border-brand-ink/10 bg-white p-5">
        @csrf
        @method('PUT')
        @include('admin.subcategories._form')
    </form>
@endsection
