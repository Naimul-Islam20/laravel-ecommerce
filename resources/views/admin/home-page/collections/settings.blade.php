@extends('admin.layouts.app')

@section('title', 'Edit Collections Layout')
@section('heading', 'Edit Collections Layout')
@section('subheading', 'Set how many columns and rows show in the homepage Collections grid')

@section('content')
    <form method="POST" action="{{ route('admin.home-page.collections-settings.update') }}" class="max-w-xl rounded-xl border border-brand-ink/10 bg-white p-5">
        @csrf
        @method('PUT')

        <div class="grid gap-4 sm:grid-cols-2">
            <div>
                <label for="collections_columns" class="mb-1 block text-sm font-medium">Columns *</label>
                <select id="collections_columns" name="collections_columns" required
                        class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
                    @foreach (range(1, 6) as $columns)
                        <option value="{{ $columns }}" @selected((int) old('collections_columns', $settings->collections_columns) === $columns)>
                            {{ $columns }}
                        </option>
                    @endforeach
                </select>
                @error('collections_columns')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="collections_rows" class="mb-1 block text-sm font-medium">Rows *</label>
                <select id="collections_rows" name="collections_rows" required
                        class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
                    @foreach (range(1, 6) as $rows)
                        <option value="{{ $rows }}" @selected((int) old('collections_rows', $settings->collections_rows) === $rows)>
                            {{ $rows }}
                        </option>
                    @endforeach
                </select>
                @error('collections_rows')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>

        <p class="mt-3 text-xs text-brand-ink/50">
            Max cards shown = Columns × Rows
            (currently
            {{ (int) old('collections_columns', $settings->collections_columns) }}
            ×
            {{ (int) old('collections_rows', $settings->collections_rows) }}
            =
            {{ (int) old('collections_columns', $settings->collections_columns) * (int) old('collections_rows', $settings->collections_rows) }}).
            Desktop uses this column count; mobile stays 2 columns.
        </p>

        <div class="mt-6 flex items-center gap-3">
            <button type="submit" class="rounded-lg bg-brand-ink px-4 py-2 text-sm font-medium text-white">Save Layout</button>
            <a href="{{ route('admin.home-page.index') }}" class="text-sm text-brand-ink/60 hover:text-brand-ink">Cancel</a>
        </div>
    </form>
@endsection
