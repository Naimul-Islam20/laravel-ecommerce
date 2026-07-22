<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Models\Category;
use App\Models\HomeSection;
use App\Models\Product;
use App\Services\SlugService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function __construct(private SlugService $slugService) {}

    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->value();

        $products = Product::query()
            ->with('category')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%")
                        ->orWhere('brand', 'like', "%{$search}%");
                });
            })
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.products.index', compact('products', 'search'));
    }

    public function create(): View
    {
        return view('admin.products.create', [
            'categories' => Category::orderBy('name')->get(),
            'product' => new Product(['currency' => 'USD', 'is_active' => true]),
            'flagSections' => HomeSection::flagType()->ordered()->get(),
            'selectedHomeSectionIds' => [],
        ]);
    }

    public function store(StoreProductRequest $request): RedirectResponse
    {
        $data = $request->validatedPayload();
        $data['slug'] = $data['slug'] ?: $this->slugService->unique($data['name'], Product::class);

        $product = Product::create($data);
        $product->homeSections()->sync($request->homeSectionIds());

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    public function edit(Product $product): View
    {
        $product->load('homeSections');

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::orderBy('name')->get(),
            'flagSections' => HomeSection::flagType()->ordered()->get(),
            'selectedHomeSectionIds' => $product->homeSections->pluck('id')->all(),
        ]);
    }

    public function update(UpdateProductRequest $request, Product $product): RedirectResponse
    {
        $data = $request->validatedPayload();
        $data['slug'] = $data['slug'] ?: $this->slugService->unique($data['name'], Product::class, $product->id);

        $product->update($data);
        $product->homeSections()->sync($request->homeSectionIds());

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
