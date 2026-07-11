<?php

use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $collections = Category::forHome()->get();
    $bestSellers = Product::bestSellers()->get();
    $topSelling = Product::topSelling()->get();
    $hingedBox = Product::hingedBox()->get();
    $trending = Product::trending()->get();
    $mealTrays = Product::mealTrays()->get();
    $roundContainers = Product::roundContainers()->get();
    $rectangularContainers = Product::rectangularContainer()->get();

    return view('home', compact(
        'collections',
        'bestSellers',
        'topSelling',
        'hingedBox',
        'trending',
        'mealTrays',
        'roundContainers',
        'rectangularContainers',
    ));
})->name('home');
