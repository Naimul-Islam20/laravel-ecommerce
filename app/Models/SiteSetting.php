<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'logo',
        'favicon',
        'company_name',
        'about_text',
        'phone',
        'email',
        'address',
        'map_url',
        'gstin',
        'facebook_url',
        'instagram_url',
        'youtube_url',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([], [
            'site_name' => 'XPERCIAINC',
            'logo' => 'images/logo-mark.svg',
            'favicon' => 'images/logo-mark.svg',
            'company_name' => 'Rp Trading Company',
            'about_text' => 'R.P. Trading Company " are Wholesaler of Disposable Plate, Plastic Box, Disposable Bowl, Disposable Tray, Pasta Tray, and much more.',
            'phone' => '9211997415',
            'email' => 'Info@Xperciainc.com',
            'address' => 'Basement, Vidhata Complex, Vasundhara Enclave, Delhi, India 110096',
            'map_url' => 'https://maps.google.com/?q=Basement,+Vidhata+Complex,+Vasundhara+Enclave,+Delhi,+India+110096',
            'gstin' => '07AJCPA7351H1ZI',
            'facebook_url' => null,
            'instagram_url' => null,
            'youtube_url' => null,
            'meta_title' => 'Eco-friendly Disposable Packaging',
            'meta_description' => 'xperciainc offers a wide range of disposable food packaging for restaurants, cloud kitchens, catering, and takeaways.',
            'meta_keywords' => 'disposable packaging, food packaging, eco-friendly packaging, meal trays, takeaway containers',
        ]);
    }

    public function defaultMetaTitle(): string
    {
        $metaTitle = trim((string) $this->meta_title);

        if ($metaTitle !== '') {
            return $metaTitle;
        }

        return trim((string) $this->site_name) ?: 'xperciainc';
    }

    public function defaultMetaDescription(): string
    {
        $description = trim((string) $this->meta_description);

        if ($description !== '') {
            return $description;
        }

        return trim((string) $this->about_text) ?: 'xperciainc offers a wide range of disposable food packaging.';
    }

    public function logoUrl(): string
    {
        return $this->mediaUrl($this->logo, 'images/logo-mark.svg');
    }

    public function faviconUrl(): string
    {
        return $this->mediaUrl($this->favicon ?: $this->logo, 'images/logo-mark.svg');
    }

    public function ogImageUrl(): ?string
    {
        $logo = trim((string) $this->logo);

        if ($logo === '') {
            return asset('images/logo-mark.svg');
        }

        return $this->logoUrl();
    }

    public function mapsHref(): string
    {
        $url = trim((string) $this->map_url);

        if ($url !== '') {
            return $url;
        }

        $address = trim((string) $this->address);

        if ($address === '') {
            return '#';
        }

        return 'https://maps.google.com/?q='.rawurlencode($address);
    }

    public function socialLinks(): array
    {
        return array_filter([
            'Facebook' => $this->facebook_url,
            'Instagram' => $this->instagram_url,
            'YouTube' => $this->youtube_url,
        ]);
    }

    private function mediaUrl(?string $path, string $fallback): string
    {
        $path = trim((string) $path);

        if ($path === '') {
            return asset($fallback);
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    }
}
