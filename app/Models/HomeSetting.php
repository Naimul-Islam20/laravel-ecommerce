<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    protected $fillable = [
        'hero_cta_text',
        'hero_cta_url',
        'collections_columns',
        'collections_rows',
    ];

    public static function current(): self
    {
        return static::query()->firstOrCreate([], [
            'hero_cta_text' => 'Shop Now',
            'hero_cta_url' => '/shop',
            'collections_columns' => 4,
            'collections_rows' => 2,
        ]);
    }

    public function collectionsColumns(): int
    {
        $columns = (int) $this->collections_columns;

        return max(1, min(6, $columns ?: 4));
    }

    public function collectionsRows(): int
    {
        $rows = (int) $this->collections_rows;

        return max(1, min(6, $rows ?: 2));
    }

    public function collectionsLimit(): int
    {
        return $this->collectionsColumns() * $this->collectionsRows();
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
