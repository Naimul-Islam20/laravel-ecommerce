<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\HomeHeroSlide;
use App\Models\HomeSection;
use App\Models\HomeSetting;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        return view('home', [
            'homeSettings' => HomeSetting::current(),
            'heroSlides' => HomeHeroSlide::active()->ordered()->get(),
            'collections' => Category::forHome()->get(),
            'homeSections' => HomeSection::active()
                ->with('category')
                ->ordered()
                ->get(),
        ]);
    }
}
