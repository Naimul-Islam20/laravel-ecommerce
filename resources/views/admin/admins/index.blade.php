@extends('admin.layouts.app')

@section('title', 'Admins')
@section('heading', 'Admin Users')
@section('subheading', 'Manage admin accounts')

@section('content')
    <div class="mb-4 flex justify-end">
        <a href="{{ route('admin.admins.create') }}" class="inline-flex rounded-lg bg-brand-ink px-4 py-2 text-sm font-medium text-white">
            Add Admin
        </a>
    </div>

    <div class="overflow-hidden rounded-xl border border-brand-ink/10 bg-white">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-brand-mist/50 text-left text-brand-ink/60">
                    <tr>
                        <th class="px-5 py-3 font-medium">Name</th>
                        <th class="px-5 py-3 font-medium">Email</th>
                        <th class="px-5 py-3 font-medium">Status</th>
                        <th class="px-5 py-3 font-medium">Last Login</th>
                        <th class="px-5 py-3 font-medium text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($admins as $admin)
                        <tr class="border-t border-brand-ink/5">
                            <td class="px-5 py-3 font-medium">
                                {{ $admin->name }}
                                @if ($admin->id === auth()->id())
                                    <span class="ml-1 text-xs text-brand-ink/50">(you)</span>
                                @endif
                            </td>
                            <td class="px-5 py-3">{{ $admin->email }}</td>
                            <td class="px-5 py-3">
                                <span class="rounded-full px-2 py-0.5 text-xs {{ $admin->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $admin->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-5 py-3 text-brand-ink/60">
                                {{ $admin->last_login_at?->diffForHumans() ?? 'Never' }}
                            </td>
                            <td class="px-5 py-3 text-right">
                                <a href="{{ route('admin.admins.edit', $admin) }}" class="mr-3 text-brand-ink/70 hover:text-brand-ink">Edit</a>
                                @can('delete', $admin)
                                    <form action="{{ route('admin.admins.destroy', $admin) }}" method="POST" class="inline"
                                          onsubmit="return confirm('Delete this admin?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-5 py-8 text-center text-brand-ink/60">No admin users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($admins->hasPages())
            <div class="border-t border-brand-ink/10 px-5 py-4">
                {{ $admins->links() }}
            </div>
        @endif
    </div>
@endsection
