<?php

namespace App\Policies;

use App\Models\User;

class AdminUserPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    public function view(User $user, User $admin): bool
    {
        return $user->isAdmin() && $admin->is_admin;
    }

    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function update(User $user, User $admin): bool
    {
        return $user->isAdmin() && $admin->is_admin;
    }

    public function delete(User $user, User $admin): bool
    {
        if (! $user->isAdmin() || ! $admin->is_admin) {
            return false;
        }

        if ($user->id === $admin->id) {
            return false;
        }

        return User::activeAdmins()->count() > 1;
    }
}
