<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Home section listings that are flag-based (not a real category tree).
     */
    private const SECTION_LISTINGS = [
        'best-sellers' => [
            'name' => 'Best Seller',
            'scope' => 'bestSellers',
        ],
        'top-selling' => [
            'name' => 'Top Selling Product',
            'scope' => 'topSelling',
        ],
        'trending' => [
            'name' => 'Trending Product',
            'scope' => 'trending',
        ],
        'biodegradable-products' => [
            'name' => 'Biodegradable Products',
            'scope' => 'biodegradableProducts',
        ],
        'new-arrivals' => [
            'name' => 'New Arrivals',
            'scope' => 'newArrivals',
        ],
    ];

    public function show(Request $request, string $slug): View
    {
        if (isset(self::SECTION_LISTINGS[$slug])) {
            return $this->showSectionListing($request, $slug, self::SECTION_LISTINGS[$slug]);
        }

        $category = Category::query()
            ->active()
            ->where('slug', $slug)
            ->with(['children' => fn ($q) => $q->active()->orderBy('sort_order')])
            ->firstOrFail();

        $categoryIds = $category->collectionCategoryIds();

        $query = Product::query()
            ->active()
            ->whereIn('category_id', $categoryIds);

        $this->applyFilters($query, $request, applyPrice: false);
        $query->orderByRaw($this->categoryGroupOrderSql($category));
        $this->applySort($query, $request);

        $products = $query->get();
        $highestPrice = (float) ($products->max('price_from') ?? 0);

        return view('collections.show', [
            'title' => $category->name,
            'collectionSlug' => $category->slug,
            'products' => $products,
            'productCount' => $products->count(),
            'highestPrice' => $highestPrice,
            'filters' => $this->filterState($request, $highestPrice),
        ]);
    }

    private function showSectionListing(Request $request, string $slug, array $section): View
    {
        $scope = $section['scope'];

        $query = Product::query()->{$scope}();

        $this->applyFilters($query, $request, applyPrice: false);
        $this->applySort($query, $request);

        $products = $query->get();
        $highestPrice = (float) ($products->max('price_from') ?? 0);

        return view('collections.show', [
            'title' => $section['name'],
            'collectionSlug' => $slug,
            'products' => $products,
            'productCount' => $products->count(),
            'highestPrice' => $highestPrice,
            'filters' => $this->filterState($request, $highestPrice),
        ]);
    }

    private function applyFilters(Builder $query, Request $request, bool $applyPrice = true): void
    {
        $availability = $request->string('availability')->toString();
        if ($availability === 'in-stock') {
            $query->where('is_active', true);
        } elseif ($availability === 'out-of-stock') {
            $query->where('is_active', false);
        }

        if (! $applyPrice) {
            return;
        }

        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        if (is_numeric($minPrice)) {
            $query->where('price_from', '>=', (float) $minPrice);
        }
        if (is_numeric($maxPrice)) {
            $query->where('price_from', '<=', (float) $maxPrice);
        }
    }

    private function applySort(Builder $query, Request $request): void
    {
        $sort = $request->string('sort')->toString() ?: 'featured';

        match ($sort) {
            'price-asc' => $query->orderBy('price_from')->orderBy('sort_order'),
            'price-desc' => $query->orderByDesc('price_from')->orderBy('sort_order'),
            'title-asc' => $query->orderBy('name')->orderBy('sort_order'),
            'title-desc' => $query->orderByDesc('name')->orderBy('sort_order'),
            default => $query->orderBy('sort_order')->orderBy('name'),
        };
    }

    private function filterState(Request $request, float $highestPrice): array
    {
        $maxPrice = $request->input('max_price');
        if ($maxPrice === null || $maxPrice === '' || ! is_numeric($maxPrice)) {
            $maxPrice = '';
        }

        $minPrice = $request->input('min_price');
        if ($minPrice === null || $minPrice === '' || ! is_numeric($minPrice)) {
            $minPrice = '';
        }

        return [
            'availability' => $request->string('availability')->toString(),
            'min_price' => $minPrice,
            'max_price' => $maxPrice,
            'sort' => $request->string('sort')->toString() ?: 'featured',
        ];
    }

    private function categoryGroupOrderSql(Category $category): string
    {
        $cases = ['CASE category_id'];
        $cases[] = 'WHEN '.(int) $category->id.' THEN 0';

        foreach ($category->children as $index => $child) {
            $cases[] = 'WHEN '.(int) $child->id.' THEN '.($index + 1);
        }

        $cases[] = 'ELSE 999 END';

        return implode(' ', $cases);
    }
}
