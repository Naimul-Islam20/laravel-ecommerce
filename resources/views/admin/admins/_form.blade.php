<div class="grid gap-4 md:grid-cols-2">
    <div>
        <label for="name" class="mb-1 block text-sm font-medium">Name *</label>
        <input id="name" name="name" type="text" value="{{ old('name', $admin->name) }}" required
               class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="email" class="mb-1 block text-sm font-medium">Email *</label>
        <input id="email" name="email" type="email" value="{{ old('email', $admin->email) }}" required
               class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
        @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="password" class="mb-1 block text-sm font-medium">
            Password {{ $admin->exists ? '(leave blank to keep current)' : '*' }}
        </label>
        <input id="password" name="password" type="password" {{ $admin->exists ? '' : 'required' }}
               class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
        @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="password_confirmation" class="mb-1 block text-sm font-medium">Confirm Password</label>
        <input id="password_confirmation" name="password_confirmation" type="password"
               class="w-full rounded-lg border border-brand-ink/15 px-3 py-2 text-sm">
    </div>
</div>

<div class="mt-4">
    <label class="flex items-center gap-2 text-sm">
        <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $admin->is_active ?? true))>
        Active
    </label>
    @error('is_active')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<div class="mt-6 flex items-center gap-3">
    <button type="submit" class="rounded-lg bg-brand-ink px-4 py-2 text-sm font-medium text-white hover:bg-brand-ink/90">
        Save Admin
    </button>
    <a href="{{ route('admin.admins.index') }}" class="text-sm text-brand-ink/60 hover:text-brand-ink">Cancel</a>
</div>
