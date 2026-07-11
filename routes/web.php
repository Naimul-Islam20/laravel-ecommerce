<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $collections = Category::forHome()->get();
    $bestSellers = Product::bestSellers()->get();
    $topSelling = Product::topSelling()->get();
    $hingedBox = Product::hingedBox()->get();
    $trending = Product::trending()->get();
    $mealTrays = Product::mealTrays()->limit(6)->get();
    $roundContainers = Product::roundContainers()->get();
    $rectangularContainers = Product::rectangularContainer()->get();
    $cornstarchProducts = Product::cornstarchProduct()->get();
    $aluminiumFoilContainers = Product::aluminiumFoilContainer()->get();
    $bagasseTableware = Product::bagasseTableware()->get();
    $biodegradableProducts = Product::biodegradableProducts()->get();
    $bagasseTakeawayContainers = Product::bagasseTakeawayContainer()->get();
    $paperProducts = Product::paperProducts()->get();
    $newArrivals = Product::newArrivals()->get();

    return view('home', compact(
        'collections',
        'bestSellers',
        'topSelling',
        'hingedBox',
        'trending',
        'mealTrays',
        'roundContainers',
        'rectangularContainers',
        'cornstarchProducts',
        'aluminiumFoilContainers',
        'bagasseTableware',
        'biodegradableProducts',
        'bagasseTakeawayContainers',
        'paperProducts',
        'newArrivals',
    ));
})->name('home');

Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/collections/{slug}', [CategoryController::class, 'show'])->name('collections.show');
