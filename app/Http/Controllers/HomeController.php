<?php

namespace App\Http\Controllers;

use App\Models\HomeCollectionItem;
use App\Models\HomeHeroSlide;
use App\Models\HomeSection;
use App\Models\HomeSetting;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $homeSettings = HomeSetting::current();

        return view('home', [
            'homeSettings' => $homeSettings,
            'heroSlides' => HomeHeroSlide::active()->ordered()->get(),
            'collections' => HomeCollectionItem::query()
                ->active()
                ->with(['category.parent'])
                ->whereHas('category', fn ($query) => $query->active())
                ->ordered()
                ->take($homeSettings->collectionsLimit())
                ->get(),
            'homeSections' => HomeSection::active()
                ->with('category')
                ->ordered()
                ->get(),
        ]);
    }
}
