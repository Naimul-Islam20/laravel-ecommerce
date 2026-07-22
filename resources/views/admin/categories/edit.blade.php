@extends('admin.layouts.app')

@section('title', 'Edit Category')
@section('heading', 'Edit Category')

@section('content')
    <form method="POST" action="{{ route('admin.categories.update', $category) }}" class="rounded-xl border border-brand-ink/10 bg-white p-5">
        @csrf
        @method('PUT')
        @include('admin.categories._form')
    </form>
@endsection
