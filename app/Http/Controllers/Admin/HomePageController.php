<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateHomeSettingRequest;
use App\Models\HomeHeroSlide;
use App\Models\HomeSection;
use App\Models\HomeSetting;
use Illuminate\View\View;

class HomePageController extends Controller
{
    public function index(): View
    {
        return view('admin.home-page.index', [
            'settings' => HomeSetting::current(),
            'heroSlides' => HomeHeroSlide::ordered()->get(),
            'sections' => HomeSection::with(['category.parent'])->ordered()->get(),
        ]);
    }

    public function updateSettings(UpdateHomeSettingRequest $request)
    {
        HomeSetting::current()->update($request->validated());

        return redirect()
            ->route('admin.home-page.index')
            ->with('success', 'Hero settings updated successfully.');
    }
}
