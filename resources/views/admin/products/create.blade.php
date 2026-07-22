@extends('admin.layouts.app')

@section('title', 'Create Product')
@section('heading', 'Create Product')

@section('content')
    <form method="POST" action="{{ route('admin.products.store') }}" class="rounded-xl border border-brand-ink/10 bg-white p-5">
        @csrf
        @include('admin.products._form')
    </form>
@endsection
