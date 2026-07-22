<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCategoryRequest;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\SlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(private SlugService $slugService) {}

    public function index(): View
    {
        $categories = Category::query()
            ->parents()
            ->withCount(['products', 'children'])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create', [
            'category' => new Category(['is_active' => true]),
        ]);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['parent_id'] = null;
        $data['slug'] = $data['slug'] ?: $this->slugService->unique($data['name'], Category::class);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['home_sort_order'] = $data['home_sort_order'] ?? 0;

        Category::create($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category): View
    {
        abort_if($category->parent_id !== null, 404);

        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        abort_if($category->parent_id !== null, 404);

        $data = $request->validated();
        $data['parent_id'] = null;
        $data['slug'] = $data['slug'] ?: $this->slugService->unique($data['name'], Category::class, $category->id);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['home_sort_order'] = $data['home_sort_order'] ?? 0;

        $category->update($data);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        abort_if($category->parent_id !== null, 404);

        if ($category->products()->exists()) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Cannot delete a category that has products.');
        }

        if ($category->children()->exists()) {
            return redirect()
                ->route('admin.categories.index')
                ->with('error', 'Cannot delete a category that has subcategories. Remove subcategories first.');
        }

        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
