@extends('admin.layouts.app')

@section('title', 'Edit Home Section')
@section('heading', 'Edit Home Section')

@section('content')
    <form method="POST" action="{{ route('admin.home-sections.update', $section) }}" class="rounded-xl border border-brand-ink/10 bg-white p-5">
        @csrf
        @method('PUT')
        @include('admin.home-page.sections._form')
    </form>
@endsection
