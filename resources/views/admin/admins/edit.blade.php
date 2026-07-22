@extends('admin.layouts.app')

@section('title', 'Edit Admin')
@section('heading', 'Edit Admin')

@section('content')
    <form method="POST" action="{{ route('admin.admins.update', $admin) }}" class="rounded-xl border border-brand-ink/10 bg-white p-5">
        @csrf
        @method('PUT')
        @include('admin.admins._form')
    </form>
@endsection
