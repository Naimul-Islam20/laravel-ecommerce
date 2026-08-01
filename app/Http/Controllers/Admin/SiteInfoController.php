<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSiteSettingRequest;
use App\Models\Product;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SiteInfoController extends Controller
{
    public function index(): View
    {
        return view('admin.site-info.index', [
            'settings' => SiteSetting::current(),
        ]);
    }

    public function update(UpdateSiteSettingRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $settings = SiteSetting::current();
        $settings->update($data);

        $siteName = trim((string) ($data['site_name'] ?? $settings->site_name)) ?: 'XPERCIAINC';
        Product::query()->update(['brand' => $siteName]);

        return redirect()
            ->route('admin.site-info.index')
            ->with('success', 'Site info updated successfully.');
    }
}
