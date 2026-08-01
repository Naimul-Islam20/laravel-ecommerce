@extends('admin.layouts.app')

@section('title', 'Contact')
@section('heading', 'Contact Messages')
@section('subheading', 'Messages submitted from the website contact form')

@section('content')
    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <form method="GET" class="flex flex-wrap items-center gap-2">
            <input
                type="search"
                name="search"
                value="{{ $search }}"
                placeholder="Search name, email, phone..."
                class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm sm:w-72"
            >
            <select name="filter" class="rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
                <option value="" @selected($filter === '')>All</option>
                <option value="unread" @selected($filter === 'unread')>Unread</option>
                <option value="read" @selected($filter === 'read')>Read</option>
            </select>
            <button type="submit" class="rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">Filter</button>
        </form>

        @if ($unreadCount > 0)
            <p class="text-sm text-brand-ink/60">
                <span class="font-medium text-brand-ink">{{ $unreadCount }}</span> unread
            </p>
        @endif
    </div>

    <div class="overflow-hidden rounded-xl border border-brand-ink/10 bg-white">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-brand-mist/50 text-left text-brand-ink/60">
                    <tr>
                        <th class="px-5 py-3 font-medium">From</th>
                        <th class="px-5 py-3 font-medium">Phone</th>
                        <th class="px-5 py-3 font-medium">Message</th>
                        <th class="px-5 py-3 font-medium">Received</th>
                        <th class="px-5 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($messages as $message)
                        <tr class="border-t border-brand-ink/5 {{ $message->is_read ? '' : 'bg-brand-mist/30' }}">
                            <td class="px-5 py-3">
                                <div class="font-medium">
                                    {{ $message->displayName() }}
                                    @unless ($message->is_read)
                                        <span class="ml-1 rounded-full bg-brand-ink px-1.5 py-0.5 text-[10px] font-semibold uppercase tracking-wide text-white">New</span>
                                    @endunless
                                </div>
                                <div class="text-xs text-brand-ink/50">{{ $message->email }}</div>
                            </td>
                            <td class="px-5 py-3 text-brand-ink/70">{{ $message->phone ?: '—' }}</td>
                            <td class="max-w-xs truncate px-5 py-3 text-brand-ink/70">
                                {{ \Illuminate\Support\Str::limit($message->comment ?: '—', 60) }}
                            </td>
                            <td class="px-5 py-3 text-brand-ink/60">
                                {{ $message->created_at?->diffForHumans() }}
                            </td>
                            <td class="px-5 py-3 text-right whitespace-nowrap">
                                <a href="{{ route('admin.contacts.show', $message) }}" class="mr-3 text-brand-ink/70 hover:text-brand-ink">View</a>
                                <form action="{{ route('admin.contacts.destroy', $message) }}" method="POST" class="inline"
                                      onsubmit="return confirm('Delete this message?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-brand-ink/60">No contact messages yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($messages->hasPages())
            <div class="border-t border-brand-ink/10 px-5 py-4">
                {{ $messages->links() }}
            </div>
        @endif
    </div>
@endsection
