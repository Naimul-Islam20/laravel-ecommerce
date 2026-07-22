<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAdminRequest;
use App\Http\Requests\Admin\UpdateAdminRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(): View
    {
        $this->authorize('viewAny', User::class);

        $admins = User::admins()
            ->orderBy('name')
            ->paginate(15);

        return view('admin.admins.index', compact('admins'));
    }

    public function create(): View
    {
        $this->authorize('create', User::class);

        return view('admin.admins.create', [
            'admin' => new User(['is_active' => true]),
        ]);
    }

    public function store(StoreAdminRequest $request): RedirectResponse
    {
        $this->authorize('create', User::class);

        $data = $request->validated();
        $data['is_admin'] = true;

        User::create($data);

        return redirect()
            ->route('admin.admins.index')
            ->with('success', 'Admin user created successfully.');
    }

    public function edit(User $admin): View
    {
        $this->authorize('update', $admin);

        return view('admin.admins.edit', compact('admin'));
    }

    public function update(UpdateAdminRequest $request, User $admin): RedirectResponse
    {
        $this->authorize('update', $admin);

        if ($admin->id === auth()->id() && ! $request->boolean('is_active')) {
            return back()
                ->withInput()
                ->withErrors(['is_active' => 'You cannot deactivate your own account.']);
        }

        if ($admin->id === auth()->id() && User::activeAdmins()->count() === 1 && ! $request->boolean('is_active')) {
            return back()
                ->withInput()
                ->withErrors(['is_active' => 'Cannot deactivate the last active admin.']);
        }

        if (! $request->boolean('is_active') && User::activeAdmins()->count() <= 1 && $admin->is_active) {
            return back()
                ->withInput()
                ->withErrors(['is_active' => 'Cannot deactivate the last active admin.']);
        }

        $data = $request->validated();

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $data['is_admin'] = true;

        $admin->update($data);

        return redirect()
            ->route('admin.admins.index')
            ->with('success', 'Admin user updated successfully.');
    }

    public function destroy(User $admin): RedirectResponse
    {
        $this->authorize('delete', $admin);

        $admin->delete();

        return redirect()
            ->route('admin.admins.index')
            ->with('success', 'Admin user deleted successfully.');
    }
}
