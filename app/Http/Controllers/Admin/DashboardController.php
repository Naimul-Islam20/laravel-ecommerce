<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard.index', [
            'totalProducts' => Product::count(),
            'activeProducts' => Product::where('is_active', true)->count(),
            'totalCategories' => Category::count(),
            'activeCategories' => Category::where('is_active', true)->count(),
            'adminCount' => User::activeAdmins()->count(),
            'recentProducts' => Product::with('category')
                ->latest()
                ->limit(5)
                ->get(),
        ]);
    }
}
