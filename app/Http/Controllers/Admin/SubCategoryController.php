<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSubCategoryRequest;
use App\Http\Requests\Admin\UpdateSubCategoryRequest;
use App\Models\Category;
use App\Services\SlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SubCategoryController extends Controller
{
    public function __construct(private SlugService $slugService) {}

    public function index(): View
    {
        $subcategories = Category::query()
            ->whereNotNull('parent_id')
            ->with('parent')
            ->withCount('products')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.subcategories.index', compact('subcategories'));
    }

    public function create(): View
    {
        return view('admin.subcategories.create', [
            'subcategory' => new Category(['is_active' => true]),
            'parents' => Category::parents()->orderBy('name')->get(),
        ]);
    }

    public function store(StoreSubCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['slug'] = $data['slug'] ?: $this->slugService->unique($data['name'], Category::class);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['show_on_home'] = false;
        $data['menu_column'] = null;
        $data['menu_row'] = null;
        $data['home_sort_order'] = 0;

        Category::create($data);

        return redirect()
            ->route('admin.subcategories.index')
            ->with('success', 'Subcategory created successfully.');
    }

    public function edit(Category $subcategory): View
    {
        abort_if($subcategory->parent_id === null, 404);

        return view('admin.subcategories.edit', [
            'subcategory' => $subcategory,
            'parents' => Category::parents()->orderBy('name')->get(),
        ]);
    }

    public function update(UpdateSubCategoryRequest $request, Category $subcategory): RedirectResponse
    {
        abort_if($subcategory->parent_id === null, 404);

        $data = $request->validated();
        $data['slug'] = $data['slug'] ?: $this->slugService->unique($data['name'], Category::class, $subcategory->id);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['show_on_home'] = false;
        $data['menu_column'] = null;
        $data['menu_row'] = null;
        $data['home_sort_order'] = 0;

        $subcategory->update($data);

        return redirect()
            ->route('admin.subcategories.index')
            ->with('success', 'Subcategory updated successfully.');
    }

    public function destroy(Category $subcategory): RedirectResponse
    {
        abort_if($subcategory->parent_id === null, 404);

        if ($subcategory->products()->exists()) {
            return redirect()
                ->route('admin.subcategories.index')
                ->with('error', 'Cannot delete a subcategory that has products.');
        }

        $subcategory->delete();

        return redirect()
            ->route('admin.subcategories.index')
            ->with('success', 'Subcategory deleted successfully.');
    }
}
