@extends('admin.layouts.app')

@section('title', 'Create Category')
@section('heading', 'Create Category')

@section('content')
    <form method="POST" action="{{ route('admin.categories.store') }}" enctype="multipart/form-data" class="rounded-xl border border-brand-ink/10 bg-white p-5">
        @csrf
        @include('admin.categories._form')
    </form>
@endsection
