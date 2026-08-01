<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSiteSettingRequest;
use App\Models\Product;
use App\Models\SiteSetting;
use App\Services\ProductImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SiteInfoController extends Controller
{
    public function __construct(private ProductImageService $imageService) {}

    public function index(): View
    {
        return view('admin.site-info.index', [
            'settings' => SiteSetting::current(),
        ]);
    }

    public function update(UpdateSiteSettingRequest $request): RedirectResponse
    {
        $data = $request->safe()->except(['logo', 'favicon']);
        $settings = SiteSetting::current();

        $data['logo'] = $this->imageService->replace(
            $settings->logo,
            $request->file('logo'),
            'site'
        );
        $data['favicon'] = $this->imageService->replace(
            $settings->favicon,
            $request->file('favicon'),
            'site'
        );

        $settings->update($data);

        $siteName = trim((string) ($data['site_name'] ?? $settings->site_name)) ?: 'XPERCIAINC';
        Product::query()->update(['brand' => $siteName]);

        return redirect()
            ->route('admin.site-info.index')
            ->with('success', 'Site info updated successfully.');
    }
}
