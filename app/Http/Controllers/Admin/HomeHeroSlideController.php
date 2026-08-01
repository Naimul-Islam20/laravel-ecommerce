<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreHomeHeroSlideRequest;
use App\Http\Requests\Admin\UpdateHomeHeroSlideRequest;
use App\Models\HomeHeroSlide;
use App\Services\ProductImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class HomeHeroSlideController extends Controller
{
    public function __construct(private ProductImageService $imageService) {}

    public function create(): View
    {
        return view('admin.home-page.hero-slides.create', [
            'slide' => new HomeHeroSlide([
                'is_active' => true,
                'sort_order' => 0,
                'button_text' => 'Shop Now',
                'button_link' => '/shop',
            ]),
        ]);
    }

    public function store(StoreHomeHeroSlideRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['image']);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['image'] = $this->imageService->store($request->file('image'), 'hero');

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
        $data = $request->safe()->except(['image']);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['image'] = $this->imageService->replace(
            $homeHeroSlide->image,
            $request->file('image'),
            'hero'
        );

        $homeHeroSlide->update($data);

        return redirect()
            ->route('admin.home-page.index')
            ->with('success', 'Hero slide updated successfully.');
    }

    public function destroy(HomeHeroSlide $homeHeroSlide): RedirectResponse
    {
        $this->imageService->delete($homeHeroSlide->image);
        $homeHeroSlide->delete();

        return redirect()
            ->route('admin.home-page.index')
            ->with('success', 'Hero slide deleted successfully.');
    }
}
