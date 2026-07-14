<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    private const PER_PAGE = 30;

    public function index(Request $request): View
    {
        $query = Product::query();

        $this->applySort($query, $request);

        $highestPrice = (float) (Product::query()->max('price_from') ?? 0);

        $products = $query->paginate(self::PER_PAGE)->withQueryString();

        return view('shop.index', [
            'title' => 'All Products',
            'products' => $products,
            'productCount' => $products->total(),
            'highestPrice' => $highestPrice,
            'filters' => $this->filterState($request),
        ]);
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

    private function filterState(Request $request): array
    {
        $availability = $request->input('availability', []);
        if (! is_array($availability)) {
            $availability = $availability === '' || $availability === null ? [] : [$availability];
        }
        $availability = array_values(array_intersect($availability, ['in-stock', 'out-of-stock']));

        return [
            'availability' => $availability,
            'min_price' => '',
            'max_price' => '',
            'sort' => $request->string('sort')->toString() ?: 'featured',
        ];
    }
}
