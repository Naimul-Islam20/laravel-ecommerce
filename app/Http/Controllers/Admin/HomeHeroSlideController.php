<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreHomeHeroSlideRequest;
use App\Http\Requests\Admin\UpdateHomeHeroSlideRequest;
use App\Models\HomeHeroSlide;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HomeHeroSlideController extends Controller
{
    public function create(): View
    {
        return view('admin.home-page.hero-slides.create', [
            'slide' => new HomeHeroSlide(['is_active' => true, 'sort_order' => 0]),
        ]);
    }

    public function store(StoreHomeHeroSlideRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['sort_order'] = $data['sort_order'] ?? 0;

        HomeHeroSlide::create($data);

        return redirect()
            ->route('admin.home-page.index')
            ->with('success', 'Hero slide added successfully.');
    }

    public function edit(HomeHeroSlide $homeHeroSlide): View
    {
        return view('admin.home-page.hero-slides.edit', [
            'slide' => $homeHeroSlide,
        ]);
    }

    public function update(UpdateHomeHeroSlideRequest $request, HomeHeroSlide $homeHeroSlide): RedirectResponse
    {
        $data = $request->validated();
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $homeHeroSlide->update($data);

        return redirect()
            ->route('admin.home-page.index')
            ->with('success', 'Hero slide updated successfully.');
    }

    public function destroy(HomeHeroSlide $homeHeroSlide): RedirectResponse
    {
        $homeHeroSlide->delete();

        return redirect()
            ->route('admin.home-page.index')
            ->with('success', 'Hero slide deleted successfully.');
    }
}
