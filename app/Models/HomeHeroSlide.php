<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeHeroSlide extends Model
{
    protected $fillable = [
        'image',
        'alt_text',
        'button_text',
        'button_link',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    public function imageUrl(): string
    {
        return app(\App\Services\ProductImageService::class)
            ->url($this->image, 'images/hero-7.png') ?? asset('images/hero-7.png');
    }

    public function buttonLabel(): string
    {
        $text = trim((string) $this->button_text);

        return $text !== '' ? $text : 'Shop Now';
    }

    public function buttonHref(): string
    {
        $url = trim((string) $this->button_link);

        if ($url === '') {
            return route('shop');
        }

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://') || str_starts_with($url, '/')) {
            return $url;
        }

        return '/'.ltrim($url, '/');
    }
}
