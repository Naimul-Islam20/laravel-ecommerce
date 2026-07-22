<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    protected $fillable = [
        'hero_cta_text',
        'hero_cta_url',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([], [
            'hero_cta_text' => 'Shop Now',
            'hero_cta_url' => '/shop',
        ]);
    }

    public function heroCtaHref(): string
    {
        $url = trim($this->hero_cta_url);

        if ($url === '') {
            return route('shop');
        }

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://') || str_starts_with($url, '/')) {
            return $url;
        }

        return '/'.ltrim($url, '/');
    }
}
