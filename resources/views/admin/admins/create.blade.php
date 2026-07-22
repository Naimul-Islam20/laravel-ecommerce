@extends('admin.layouts.app')

@section('title', 'Create Admin')
@section('heading', 'Create Admin')

@section('content')
    <form method="POST" action="{{ route('admin.admins.store') }}" class="rounded-xl border border-brand-ink/10 bg-white p-5">
        @csrf
        @include('admin.admins._form')
    </form>
@endsection
