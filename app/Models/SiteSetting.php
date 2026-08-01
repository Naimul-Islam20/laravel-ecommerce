<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'currency',
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
        return once(fn () => static::resolveCurrent());
    }

    private static function resolveCurrent(): self
    {
        return static::query()->firstOrCreate([], [
            'site_name' => 'XPERCIAINC',
            'currency' => 'Rs.',
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

    public function currencyLabel(): string
    {
        $currency = trim((string) $this->currency);

        return $currency !== '' ? $currency : 'Rs.';
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

    public function mapsEmbedUrl(): ?string
    {
        $address = trim((string) $this->address);
        $mapUrl = trim((string) $this->map_url);

        if ($address === '' && $mapUrl === '') {
            return null;
        }

        $query = $address !== '' ? $address : $mapUrl;

        if (preg_match('/[?&]q=([^&]+)/', $mapUrl, $matches)) {
            $query = urldecode($matches[1]);
        }

        return 'https://maps.google.com/maps?q='.rawurlencode($query).'&z=15&output=embed';
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
        return app(\App\Services\ProductImageService::class)
            ->url($path, $fallback) ?? asset($fallback);
    }
}

