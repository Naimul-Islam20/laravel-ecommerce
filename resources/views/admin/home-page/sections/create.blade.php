@extends('admin.layouts.app')

@section('title', 'Add Home Section')
@section('heading', 'Add Home Section')

@section('content')
    <form method="POST" action="{{ route('admin.home-sections.store') }}" class="rounded-xl border border-brand-ink/10 bg-white p-5">
        @csrf
        @include('admin.home-page.sections._form')
    </form>
@endsection
