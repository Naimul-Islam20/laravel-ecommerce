@extends('admin.layouts.app')

@section('title', 'Contact Message')
@section('heading', 'Contact Message')
@section('subheading', 'Submitted '.$message->created_at?->format('d M Y, h:i A'))

@section('content')
    <div class="mb-4">
        <a href="{{ route('admin.contacts.index') }}" class="text-sm text-brand-ink/60 hover:text-brand-ink">← Back to messages</a>
    </div>

    <div class="rounded-xl border border-brand-ink/10 bg-white p-5 sm:p-6">
        <dl class="grid gap-4 sm:grid-cols-2">
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-brand-ink/50">Name</dt>
                <dd class="mt-1 text-sm font-medium">{{ $message->displayName() }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-brand-ink/50">Email</dt>
                <dd class="mt-1 text-sm">
                    <a href="mailto:{{ $message->email }}" class="underline underline-offset-2">{{ $message->email }}</a>
                </dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-brand-ink/50">Phone</dt>
                <dd class="mt-1 text-sm">
                    @if ($message->phone)
                        <a href="tel:{{ preg_replace('/\s+/', '', $message->phone) }}" class="underline underline-offset-2">{{ $message->phone }}</a>
                    @else
                        —
                    @endif
                </dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase tracking-wide text-brand-ink/50">Received</dt>
                <dd class="mt-1 text-sm">{{ $message->created_at?->format('d M Y, h:i A') }}</dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-xs font-semibold uppercase tracking-wide text-brand-ink/50">Comment</dt>
                <dd class="mt-2 whitespace-pre-wrap rounded-lg border border-brand-ink/10 bg-brand-mist/40 p-4 text-sm leading-relaxed">
                    {{ $message->comment ?: '—' }}
                </dd>
            </div>
        </dl>

        <div class="mt-6 flex flex-wrap items-center gap-3">
            <a href="mailto:{{ $message->email }}" class="rounded-lg bg-brand-ink px-4 py-2 text-sm font-medium text-white hover:bg-brand-ink/90">
                Reply by email
            </a>
            <form action="{{ route('admin.contacts.destroy', $message) }}" method="POST"
                  onsubmit="return confirm('Delete this message?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="rounded-lg border border-red-200 px-4 py-2 text-sm font-medium text-red-600 hover:bg-red-50">
                    Delete
                </button>
            </form>
        </div>
    </div>
@endsection
