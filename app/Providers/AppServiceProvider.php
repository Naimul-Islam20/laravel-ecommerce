<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\User;
use App\Policies\AdminUserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Password::defaults(function () {
            return Password::min(12)
                ->mixedCase()
                ->numbers()
                ->symbols();
        });

        Gate::policy(User::class, AdminUserPolicy::class);

        Route::bind('admin', function (string $value) {
            return User::admins()->findOrFail($value);
        });

        View::composer(['partials.header', 'partials.footer'], function ($view) {
            $menuCategories = Category::forMenu()->get()->groupBy('menu_column');

            $view->with('menuColumns', $menuCategories);
        });
    }
}
